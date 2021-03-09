<?php
declare(strict_types=1);

namespace Loop\Tracker\Observer\Frontend\Checkout;

use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Pricing\Helper\Data as PricingHelper;
use Magento\Quote\Model\Quote\Item;
use Psr\Log\LoggerInterface;
use Magento\Checkout\Model\Session;
use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Framework\Message\ManagerInterface;
use Loop\Tracker\Model\ItemsRepository;
use Loop\Tracker\Api\Data\ItemsInterface;

class CartAddProductComplete implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var Session
     */
    protected $checkoutSession;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var ItemsRepository
     */
    protected $trackingItemsRepository;

    /**
     * @var ItemsInterface
     */
    protected $trackingItemsData;

    /**
     * API request URL
     */
    const API_REQUEST_URI = 'https://supertracking.view.agentur-loop.com/';

    /**
     * API request endpoint as "trackme".
     */
    const API_REQUEST_ENDPOINT = 'trackme';

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * @var PricingHelper
     */
    private $pricingHelper;

    /**
     * GitApiService constructor
     *
     * @param ItemsInterface $_trackingItemsData
     * @param ItemsRepository $_trackingItemsRepository
     * @param ManagerInterface $_messageManager
     * @param PricingHelper $_pricingHelper
     * @param LoggerInterface $_logger
     * @param Session $_checkoutSession
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     */
    public function __construct(
        ItemsInterface $_trackingItemsData,
        ItemsRepository $_trackingItemsRepository,
        ManagerInterface $_messageManager,
        PricingHelper $_pricingHelper,
        LoggerInterface $_logger,
        Session $_checkoutSession,
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory
    ) {
        $this->trackingItemsData = $_trackingItemsData;
        $this->trackingItemsRepository = $_trackingItemsRepository;
        $this->messageManager = $_messageManager;
        $this->pricingHelper = $_pricingHelper;
        $this->checkoutSession = $_checkoutSession;
        $this->logger = $_logger;
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     * @throws LocalizedException
     */
    public function execute(
        Observer $observer
    ) {
        /** @var Product $product */
        $product = $observer->getEvent()->getDataByKey('product');

        /** @var Item $item */
        $item = $this->checkoutSession->getQuote()->getItemByProduct($product);

        $price = $item->getPrice();
        $sku = $item->getSku();

        $response = self::doRequest(
            self::API_REQUEST_URI,
            ['body' => json_encode(['sku' => $sku, 'price' => $price])],
            Request::HTTP_METHOD_POST
        );

        $this->messageManager->addNoticeMessage("Loop tracking: " . $response->getReasonPhrase());

        if ($response->getStatusCode() == "200") {
            $responseBody = json_decode($response->getBody()->read(1024), true);

            $items = $this->trackingItemsData
                ->setCreatedAt(date('Y-m-d H:i:s'))
                ->setSku($sku)
                ->setTrackingCode($responseBody['message'])
                ->setTrackingMessage($responseBody['code']);
            $this->trackingItemsRepository->save($items);
        }
    }

    /**
     * Do API request with provided params
     *
     * @todo Could be as part for Helper class.
     *
     * @param string $uriEndpoint
     * @param array $params
     * @param string $requestMethod
     *
     * @return Response
     */
    private function doRequest(
        string $uriEndpoint,
        array $params = [],
        string $requestMethod = Request::HTTP_METHOD_GET
    ): Response {
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => self::API_REQUEST_URI
        ]]);

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                $params
            );
        } catch (GuzzleException $exception) {
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }
        return $response;
    }
}
