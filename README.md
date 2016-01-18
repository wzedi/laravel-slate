laravel-slate
================
Generate tripit/slate documentation directly from Laravel controllers.

Install
------

```json
// composer.json
"require": {
    "cadreworks/laravel-slate": "dev-master"
}
```

Usage
-----
* Use `CadreWorks\LaravelSlate\DocumentGenerator` in your Controller

```php
use CadreWorks\LaralvelSlate\DocumentGenerator;
```

* Add the following line to your

```php
// config/services.php
    ...
    'dynamodb' => [
        'key' => env('DYNAMODB_KEY'),
        'secret' => env('DYNAMODB_SECRET'),
        'region' => env('DYNAMODB_REGION'),
        'local_endpoint' => env('DYNAMODB_LOCAL_ENDPOINT') // see http://docs.aws.amazon.com/amazondynamodb/latest/developerguide/Tools.DynamoDBLocal.html
        'local' => env('DYNAMODB_LOCAL')
    ],
    ...
```

Test
----
Run:

```bash
$ java -Djava.library.path=./DynamoDBLocal_lib -jar dynamodb_local/DynamoDBLocal.jar --port 3000
$ ./vendor/bin/phpunit
```

This is the [test table created for DynamoDb local by the DynamoDb local shell](http://docs.aws.amazon.com/amazondynamodb/latest/developerguide/Tools.DynamoDBLocal.Shell.html)

```javascript
var params = {
    TableName: 'test_model',
    KeySchema: [ // The type of of schema.  Must start with a HASH type, with an optional second RANGE.
        { // Required HASH type attribute
            AttributeName: 'id',
            KeyType: 'HASH',
        }
    ],
    AttributeDefinitions: [ // The names and types of all primary and index key attributes only
        {
            AttributeName: 'id',
            AttributeType: 'S', // (S | N | B) for string, number, binary
        },
        {
            AttributeName: 'count',
            AttributeType: 'N', // (S | N | B) for string, number, binary
        }
    ],
    ProvisionedThroughput: { // required provisioned throughput for the table
        ReadCapacityUnits: 1, 
        WriteCapacityUnits: 1, 
    },
    GlobalSecondaryIndexes: [ // optional (list of GlobalSecondaryIndex)
        { 
            IndexName: 'count_index', 
            KeySchema: [
                { // Required HASH type attribute
                    AttributeName: 'count',
                    KeyType: 'HASH',
                }
            ],
            Projection: { // attributes to project into the index
                ProjectionType: 'ALL', // (ALL | KEYS_ONLY | INCLUDE)
            },
            ProvisionedThroughput: { // throughput to provision to the index
                ReadCapacityUnits: 1,
                WriteCapacityUnits: 1,
            },
        },
        // ... more global secondary indexes ...
    ]
};
dynamodb.createTable(params, function(err, data) {
    if (err) print(err); // an error occurred
    else print(data); // successful response
});
```

* DynamoDb local version: 2015-07-16_1.0

TODO
----
* Upgrade a few legacy attributes: `AttributesToGet`, `ScanFilter`, ...


Requirements:
-------------
Laravel 5.1

License:
--------
MIT

Author:
-------
Bao Pham
