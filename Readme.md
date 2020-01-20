#Domain Events
This repo is created to demonstrate the work with `domain events` in Doctrine environment.

It's just a generic code to demonstrate the idea, but not a working project.

Here you can find entity `Product` with two raised events: `ProductCreated` and `ProductNameChanged`.
Every event will be processed on persisting data to DB (see Doctrine listener `DomainEventsSubscriber`).
Event can be processed immediately (sync) or put to async storage to postponed processing (async).