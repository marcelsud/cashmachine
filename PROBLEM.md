# Cash Machine

## The Problem

Develop a solution that simulate the delivery of notes when a client does a withdraw in a cash machine.


The basic requirements are the follow:

- Always deliver the lowest number of possible notes;
- It’s possible to get the amount requested with available notes;
- The client balance is infinite;
- Amount of notes is infinite;
- Available notes $ 100,00; $ 50,00; $ 20,00 e $ 10,00


Example:


Entry: 30.00
Result: [20.00, 10.00]

Entry: 80.00
Result: [50.00, 20.00, 10.00]

Entry: 125.00
Result: throw NoteUnavailableException

Entry: -130.00
Result: throw InvalidArgumentException

Entry: NULL
Result: [Empty Set]


## The Deliverables:

Make sure your code is well written, focus in good practices and prepare a small (10 minutes) talk/explanation about the decisions in your code/architecture. 

The usage of libraries or frameworks is allowed, if this make your test easier or better feel free to make use of those.

With the test please delivery:

- API endpoint(s) to test the code
- Tests
- any other material you think could be relevant to enrich your test and why
