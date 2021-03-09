# The Mini Tracker

    ``loop/module-tracker``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)
 - [Loop API bug](#markdown-header-loop-api-bug)
 - [Time tracking](#markdown-header-time-tracking)



## Main Functionalities
The implementation of a mini tracking client in a Magento 2 backend. Its goal is to invoke a service, each time a product was added to customers cart. The service responds with a tracking ID. Store this tracking ID in the local Magento database as dedicated model. Finally expose this data via a REST API.

## Installation
bin/magento mod:en Loop_Tracker  
bin/magento s:up  
bin/magento s:di:c


## Specifications

 - API Endpoint
	- GET - Loop\Tracker\Api\TrackingManagementInterface > Loop\Tracker\Model\TrackingManagement

 - Observer
	- checkout_cart_add_product_complete > Loop\Tracker\Observer\Frontend\Checkout\CartAddProductComplete

## Loop API bug
I believe loop api "price" parameter accepts only float variable types. If price parameter in request would be integer (**1**) or string (**"3.00"**) - LOOP API will not accept it and give you a message "**400 Bad Request` response: {"message":"Provide valid price"}**" 

## Time tracking
| Task        | Estimated           | Real  |
| ------------- |:-------------:| -----:|
| Module skeleton (model, observer, webapi)       | 1h | 2h |
| Observer product and REST client call to LOOP      | 2h      |   3h (due Loop bug I believe) |
| Magento webapi      |    2h | 2h


