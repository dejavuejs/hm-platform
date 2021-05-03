# Introduction
Your basic laravel dashboard with all the required settings to manage your customers and very necessary accounting done with ability to create multiple domain 
implementations for frontend and not enable frontend at all.

# Code reusability - DONT REPEAT YOURSELF.
Wait! we are writing too many things on repetition and have accepted that as reality. Ex: Your regular day to day HTML forms. Writing static pages directly 
in your HTML from scratch. Or maybe you are using Wordpress a huge bloat of autoloaded container with lots of dirty security flaws that you don't know when
its day zero or face support outage in near future, for what writing static pages (SHAME!!!).

On severe analysis i found we're blocking our abilities (SUPERPOWERS!!!) to create great things on daily basis. Microservices is so difficult to make
because you feel no use case for it with your current approaches. But code reusabilty unlocks various possibilities in your IT evolution and verticals that 
we dreamt to make reality.

Orca dashboard gives you plain basic customers, channels, sales features and OPENAPI ready for third party context usage such as your existing ERP/XERO/etc.
SAAS based approach also available. 

# Features:
    1. Customers
    2. Sales (Invoices/Orders).
    3. Manage customer and tie them to vertical type.
    4. Manage organization's core integrities.
    5. Use laravel blade for creating static pages.
    6. Headless CMS also will be made available shortly.
    7. Core attributes.
    8. Engage your customers directly via mails or notification channels such as SMS, etc. 
    
Orca is designed to help you in able ways to reuse code in a very possibly friendly manner. Its usage with AppStore is a total different perspective all together.
Binding Orca with AppStore will give you dependencies such as system attributes/products/services being pushed and pulled to and fro for our customers at blink of an eye.

# Now lets talk about attributes:
Digital information exists in two forms only:
1. Structured (DB - Disk/RAM).
2. Unstructured (SD/Disk).

Both existence are now possible in DB (In memory / SQL) or Disk. Ex: MySQL, MongoDB, S3, local disk, etc.

Attributes are core for any IT organization to rely on. Its really ignored but they have a very high significant usage. If we really wanna make services / apps 
valuble then we should be able to implement it across verticals. We really tend to ignore attributes and customer management from the start and do work without
a central command communication system with your clients.
Attributes are vivid when constructed as they goes across our application via Arrays, JSON, DB records and OOP properties. Attributes can be used to make resources with its own properties and provide CRUD API on the go. They are hard to find but they exists everywhere if information flowing is dynamic and stored in above two
types. So we have figured out the solution and this dashboard will soon become capable with it.

# Attributes are important!
Attributes are your daily used language primitive types, composable type of service units whether stored in certain kind of memory system or get derived when 
required.

# What need to do, now (better late than never)
Just to manage resources and referential integrity we write schemas and views to make it usable as a service for end customers. While services which cannot 
be seen complete via attributes or are better implemented by someone such as AWS SNS/SQL/Redis/etc can be coupled in modules and packages and be used with 
appstore. We now get a complete picture of our clients now & what they are using so they are now real easy to be invoiced very accurately.

# Imagine (Apple falling from tree):
AppStore - running with Orca or any laravel panel will be able to use attributes throughout. We can push complex attributes to our clients while they pay us on the go for it.

# How will Attributes work:
Current implmentation leaves us to JSON validation. Where we need to imagine a single webpage screen as a document. Wait! document as in HTML and document as in
JSON both?
Yes!

### Consider this use case:
End customer putting registration information via registration form and he know that using inspect element of browser he can manipulate DOM. And then submits
the form. You will never get to know if DOM was manipulated before form was submitted. And this is a very big problem we face from minnow hackers.
### I firmly assure there are innumerable uses cases more.

While the above use case validates over importance of documents management now. And we were doing things wrong right from the start. Instead of compliance we 
were manually testing. Suddenly the automation tests makes sense. 

We just need these things as developers to sell products:
1. Running code.
2. Documentation.
3. Tests

With the above required points we will move on for futher develop, document and test. Its my request to contribute via code and concepts so we can make accurate
requirements.

# Attributes are in development currently.
Attributes is a very complex topic to rely on. And it need many things apart from holding value for a resource. A resource attribute might be getting used across
your as a property that is end customer service centric. Or in simple words we need cross platform objects and attributes is a very very special way to achieve it.

Common attribute types:
1. String
2. Text
3. Boolean
4. Date
5. Datetime
6. JSON
7. Array
8. Composable
9. Link
10. Password
11. Email
12. etc.

Attributes in Orca are under progress with usage of JSON schemas we intend to test and deploy attributes to be used in resources. A generic attibute have these common properties:
1. Visibility
2. Type
3. Render logic
4. Store logic
5. Required
6. Immutable (i18n)

## There are two type of attributes:
1. Core
2. Derived or composable

The above two types also gets inherited in our CRUD and referential resources. May be our application resources use attributes and make some of those attributes 
as core attributes (in simple word as required information when creating a resource entry) these type of attributes are core.
Maybe you need to create an attribute called price but you created it using core types. One important thing about core attributes is in regard that they shouldn't
have Render logic and are non immutable.

While on the other hand a business vertical have complex attribute such as price of product or maybe your image slider or whatever. They tend to have some render
logic and store logic and can be immuatable due to localization and i18n. So derived or composable attributes are made up from core attributes and system properties
such as Timezone, Units, etc.

## Resources as composition of attributes and attributes are composed from JSON schemas that are validated (win win for all).
When next time a static page is being rendered for end customer it should be schema rendered and assured by attributes of system. Since you don't change your static page on daily basis or not it can be defined using set of attributes and it make more sense when you name your static page resource CMS now.

Orca can create resource via attributes. With this product owner make attribute implementations and gives us concrete approach through which we can achieve code reusability. Since single admin panel is all you ever wanted to serve your customers its like your central command. That is able to manage very essential information across your services.

Orca is functional but it is under development and is getting rapidly updated and ready for our own usage.

