This repo is just a generic code to demonstrate the work with Domain Events.
Here you can find entity `Product` with two raised events: `ProductCreated` and 'NameChanged'.
Every event will be processed on persisting data to DB (see Doctrine listener `DomainEventsSubscriber`).
Event can be processed immediately (sync) or put to async storage to postponed processing (async).