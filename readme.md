# Problem
You are tasked with designing an algorithm to dispatch messages from a queue to a set of given recipients. Messages with varying numbers of recipients are added to the queue concurrently by multiple clients. Your algorithm should ensure that all queued messages are attended to fairly. Additionally, it should handle any conflicts that may arise due to concurrent modifications of the queued messages. To achieve this you are provided a database with following tables and sample data.

Table: messages
```
id: Integer
content: String
status: String
scheduled_date: DateTime
delivered_date: DateTime
```
Table: recipients
```
id: Integer
message_id: (Integer - Foreign Key to messages.id)
email_address: String
status: String
delivered_date: DateTime
```
# Constraints:
- Each message can have a varying number of recipients.
- The algorithm should handle concurrent modifications of the queue by multiple clients, ensuring fair dispatch to the given recipients.
- No message should be modified while on dispatch.
- Focus on how to process the queue and ignore how the message is actually delivered.
- You can use any programming language to solve this problem. Good luck with your implementation!

# Setup

run to initialize database and seed data  
```docker-compose -f docker-compose.yml -f faker/faker-compose.yml up```  
consecutive runs should only run the database  
```docker-compose up```  
