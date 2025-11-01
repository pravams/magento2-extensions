# magento2-extensions
Magento 2 custom extensions and themes that enhance magento 2 features:

## List of Extensions

* [Recurring Order](#1-recurring-order)
* [Headless Theme](#2-headless-theme)
* [Reward](#3-reward)
* [Chat](#4-chat)
* [Giftcard](#5-giftcard)
* [Ticket](#6-ticket)
* [Reservation](#7-reservation)

## 1.) Recurring Order

This Recurring Order extension for Magento makes it easier for customers to create repeat orders by creating subscription orders based on a frequency for offline payment methods.  With this Recurring Order extension, customers can use it to create a subscription for the product. And the order will be placed automatically every week based on the frequency that they select.

* Frontend:-

    * You can add any number of products for subscription
    * Subscription can be customized to any frequency which can be daily, weekly, monthly, etc
    * The subscription can be created for any shipping method
    * The subscription is currently supported for simple products only
    * The subscription can be created for offline payment methods only
 
* Admin Backend:-

    * View the subscription details created by the customer from Magento Admin.
    * Ability to make the subscription inactive, active, or delete it.
    * View the orders placed through the subscription.

**Download Link:-** <https://github.com/pravams/magento2-extensions/tree/main/app/code/Pravams/RecurringOrder>


## 2.) Headless Theme

This Magento theme, removes the default "head"(mostly CSS) in Magento, and makes it very easy for the front-end developers to replace this head with another head(CSS design) and create a new theme for Magento very quickly, so it is named as a Headless theme.

* Features:-

    * It does not inherit the out of the box Magento’s Luma or the Blank theme’s design or layout. But it is using an open source W3 CSS example template as the base theme design and layout. And this entirely different CSS and HTML is integrated into Magento as a shopping cart theme.
    * This is a pure "Frontend theme" with changes in HTML, CSS and Javascript only and there are no modifications in the app/code folder.
    * For the checkout to happen, it is using the default or Out of the box existing REST APIs of Magento.
    * It is built as a SPA(Single Page Application), which means that all the features of this theme can be accessed without reloading or refreshing the page.
    * This theme is also open source, so it can be customised easily to convert it into a full fledged eCommerce website as well.
    * It is created primarily to help the Frontend developer quickly integrate their new designs in the form of HTML, CSS into Magento easily.
    * It is very simple to use and understand, and requires very less backend module creation knowledge, to customise this theme.
 
* Key points :-
    * It allows only guest customer checkout currently
    * It allow first level category navigation
    * We can List only Simple products
    * We can View only Simple products
    * View cart and Remove items if needed
    * Add Shipping and Billing Address 
    * Select Shipping method
    * Select Offline payment method
    * Place order only as a guest user


**Download Link:-** <https://github.com/pravams/magento2-extensions/tree/main/app/design/frontend/Pravams/headless>


## 3.) Reward

This Reward extension for Magento provides a way for the customer to earn Reward points. The reward points are given to the customer for completing an activity. These points can also be redeemed to get discounts on the customer's purchases. This also increases the customers engagement with the site thereby increasing traffic and sales as well.

* Frontend:-

    * Customer earns points for activities like (Registration, Newsletter Subscription, Product Review, Wishlist Sharing and Placing Order)
    * The customer can view the reward points earned for all his activity
    * The customer can redeem the points by entering the number of points on the shopping cart page
    * The cart value is discounted in proportion to the number of points redeemed during checkout    
    * The customer can also see the number of reward points redeemed as well.
 
* Admin Backend:-

    * These points can be proportioned to the currency value, which is configurable in Magento admin. For example (1 Reward point = $10)
    * Ability to enable or disable rewards for specific activity also
    * Assign a custom value of the reward points earned for every activity
    * Can see the reward points earned and redeemed by every customer
    * Please note that there is a restriction/limit of 24 hours in earning reward points from (Product review and Wishlist activities) successively for the customer

**Download Link:-** <https://github.com/pravams/magento2-extensions/tree/main/app/code/Pravams/Reward>

## 4.) Chat

This Chat extension for Magento provides a way for the customers to chat with the website support or Magento admin users. This provides a quick and easy way for the customers to ask questions or clear doubts, thereby increasing customer satisfaction. This also increases the customers engagement with the site thereby increasing traffic and sales as well. This exension is using minimum javascript, so the site performance is not affected by this extension.

* Frontend:-

    * Customer can chat with the website support team
    * Customer has to log in to start chatting.
    * The customer can refresh the page to see new messages
    * Cusomer can also see, if thier messages are read by the Support team
    * SPAM block to avoid excessive messaging

* Admin Backend:-

    * They can chat with mutiple customers from the same place
    * They can also delete the chat
    * Admin can also see, if thier messages are read by the Customer
    * SPAM block to avoid excessive messaging
    * Admin can blacklist a customer and disable his chat

**Download Link:-** <https://github.com/pravams/magento2-extensions/tree/main/app/code/Pravams/Chat>

## 5.) Giftcard

This Giftcard extension allows the customers to gift their loved ones a method to purchase products on a merchant's website.

For example, John may want to gift his Dad an electronic item for Christmas. But instead of buying the product, he buys a gift card worth $100 online. His Dad receives the Email with the Gift card Code. Then he can go to the merchant store and buy his favorite electronic product whether iPhone or iPad from the Merchant website by using the gift card code.

This would increase the sales of the merchant's store, as the number of orders will increase due to the use of Gift cards as another way of placing orders. From the customer perspective it is easier to place orders by applying gift cards to orders and get discounts. Customers get a chance to thank people in their lives by giving them a gift. And also feel satisfied with their token of appreciation.


* Frontend:-

    * You can purchase a Gift card product online and send a Gift card code to the receiver.
    * Giftcard can be adedd to cart by providing "gift amount", "Receiver email", "Receiver name" and "Message"
    * Gift card code is an eight-digit code sent to the recipient email.
    * The recipient can use this code to buy any product on the website.
    * The Gift card code can be used any number of times until its value is exhausted.
    * Gift card discount is visible on order totals, PDF, and emails.    
    * This module is designed for the Magento Luma theme
 
* Admin Backend:-

    * You can create any number of Gift card products that are virtual.
    * Gift cards have a minimum and maximum value that can be configured in the admin.
    * Gift card discount is visible on order totals, PDF, and emails.

**Download Link:-** <https://github.com/pravams/magento2-extensions/tree/main/app/code/Pravams/Giftcard>


## 6.) Ticket

This Ticket extension for Magento provides a way for the customers to create a Support Ticket for ongoing communication with website support team. It allows the customer to write down thier issues or questions in details with screenshots etc on the website and expect a reliable resolution. 
This provides a comprehensive way for the customers to track and ask questions related to the website, products purchase or returns, thereby increasing customer satisfaction. This also increases the customers engagement with the site thereby increasing traffic and sales as well.

* Frontend:-

    * Customer can create a Support ticket for the website support team.
    * Cusomer can set priority of the issue, indicating its urgency.        
    * Customer can upload images in the ticket.
    * Customer can close the ticket after it is resolved.    
    * An email notification is sent to the website support, when customer creates a ticket or replies to it.
    * SPAM block to avoid excessive ticket and reply posting.

* Admin Backend:-

    * Can view, search and filter the tickets created by the customer.
    * Can reply to the ticket and upload images also.    
    * Admin can close a ticket also, on behalf of the customer.    
    * An email notification is sent to the customer on every reply also.
    * SPAM block to avoid excessive reply posting.

**Download Link:-** <https://github.com/pravams/magento2-extensions/tree/main/app/code/Pravams/Ticket>


## 7.) Reservation

This Reservation or Bookings extension for Magento provides a way for the customers to buy products that need a reservation (or that require a date input mandatorily) while adding them to the cart.
For example, the owner of a guest house or hotel can use this extension, where his customers can book the dates of their stay.


* Frontend:-

    * Customers can view the reservation products list.
    * Customers can add the product after providing the reservation name and selecting the date.
    * Customer can see his selected date during all the steps of checkout.
    * Customer can see the booked dates on his email and pdf also.
    * Ideal Customers who may want this extension would be Movie Ticket Sellers, Hotel Rooms seller, Food reservation sites for restaurants, event organizing, seat bookings in travel etc. and many other such places who have to collect the date and name on thier product for sale.

* Admin Backend:-

    * Admin can log into admin and go to Pravams->All Reservations. And he can view, search the orders placed by reservation name, order# or booking place name.
    * Admin can also see the customer's selected dates of the booking.
    * The inventory is deducted after the purchase for the booking place, so Admin can estimate accordingly

**Download Link:-** <https://github.com/pravams/magento2-extensions/tree/main/app/code/Pravams/Reservation>
