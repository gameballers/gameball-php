<?php
//-------------------------------------SDK Examples in PHP -------------------------------
// Events

//Example 1

$gameball = new \Gameball\GameballClient('API_KEY','TRANS_KEY');

$eventRequest = new \Gameball\Models\EventRequest();
$eventRequest->addEvent('place_order');

$eventRequest->addMetaData('place_order','total_amount','100');
$eventRequest->addMetaData('place_order','category',array("electronics","cosmetics"));

$eventRequest->addEvent('review');


$playerRequest = \Gameball\Models\PlayerRequest::factory('player123');
$eventRequest->playerRequest = $playerRequest;

$res= $gameball->event->sendEvent($eventRequest);

echo $res->body;

//Example 2

$gameball = new \Gameball\GameballClient('API_KEY','TRANS_KEY');

$eventRequest = new \Gameball\Models\EventRequest();
$eventRequest->addEvent('reserve');

$eventRequest->addMetaData('reserve','rooms',2);


$playerAttributes = new \Gameball\Models\PlayerAttributes();
$playerAttributes->displayName = 'Jon Snow';
$playerAttributes->email = 'jon.snow@example.com';
$playerAttributes->dateOfBirth = '1980-09-19T00:00:00.000Z';


$playerRequest = \Gameball\Models\PlayerRequest::factory('player123' , $playerAttributes);
$eventRequest->playerRequest = $playerRequest;

$res= $gameball->event->sendEvent($eventRequest);

echo $res->body;


//Example 3

$gameball = new \Gameball\GameballClient('API_KEY','TRANS_KEY');

$eventRequest = new \Gameball\Models\EventRequest();
$eventRequest->addEvent('reserve');

$eventRequest->addMetaData('reserve','rooms',2);


$playerAttributes = new \Gameball\Models\PlayerAttributes();
$playerAttributes->displayName = 'Jon Snow';
$playerAttributes->email = 'jon.snow@example.com';
$playerAttributes->dateOfBirth = '1980-09-19T00:00:00.000Z';

$playerAttributes->addCustomAttribute('location' , 'Miami');
$playerAttributes->addCustomAttribute('graduationDate' , '2018-07-04T21:06:29.158Z');
$playerAttributes->addCustomAttribute('isMarried' , false);


$playerRequest = \Gameball\Models\PlayerRequest::factory('player123' , $playerAttributes);
$eventRequest->playerRequest = $playerRequest;

$res= $gameball->event->sendEvent($eventRequest);

echo $res->body;



//Referrals

//Example 1
$gameball = new \Gameball\GameballClient('API_KEY','TRANS_KEY');

$playerCode ='CODE11';



$playerRequest = \Gameball\Models\PlayerRequest::factory('player456');


$res= $gameball->referral->createReferral($playerCode,$playerRequest);
echo $res->body;


//Example 2

$gameball = new \Gameball\GameballClient('API_KEY','TRANS_KEY');

$playerCode ='CODE11';


//All are optional
//displayName, firstName, lastName, email, gender, mobileNumber, dateOfBirth
$playerAttributes = \Gameball\Models\PlayerAttributes::factory('Tyrion Lannister',
                                                          'Tyrion',
                                                          'Lannister',
                                                          'tyrion@example.com',
                                                          'M', , // empty for mobileNumber
                                                          '1978-01-11T00:00:00.000Z',
                                                          );

//custom attributes <Key => Value>
$playerAttributes->addCustomAttribute('location','Miami');
$playerAttributes->addCustomAttribute('graduationDate' , '2018-07-04T21:06:29.158Z');
$playerAttributes->addCustomAttribute('isMarried' , false);



$playerRequest = \Gameball\Models\PlayerRequest::factory('player456',$playerAttributes);



$res= $gameball->referral->createReferral($playerCode,$playerRequest);
echo $res->body;



//Reward

//Example 1

$gameball = new \Gameball\GameballClient('API_KEY','TRANS_KEY');



$playerRequest =new \Gameball\Models\PlayerRequest();
$playerRequest->playerUniqueId='player123';


$amount = '99.98';
$transactionId ='tra_123456789';


$branch = \Gameball\Models\Branch::factory('bid123' , 'bname123');

$merchant = new \Gameball\Models\Merchant();
$merchant->uniqueId = 'mid123';
$merchant->name = 'mname123';
$merchant->branch = $branch;


$res= $gameball->transaction->rewardPoints($playerRequest,$amount ,$transactionId, $merchant);
echo $res->body;



//Example 2

$gameball = new \Gameball\GameballClient('API_KEY','TRANS_KEY');

//All are optional
//displayName, firstName, lastName, email, gender, mobileNumber, dateOfBirth
$playerAttributes = new \Gameball\Models\PlayerAttributes();

$playerAttributes->displayName ='Tyrion Lannister';
$playerAttributes->firstName ='Tyrion';
$playerAttributes->lastName ='Lannister';
$playerAttributes->email ='tyrion@example.com';
$playerAttributes->gender ='M';
$playerAttributes->dateOfBirth ='1978-01-11T00:00:00.000Z';


//custom attributes <Key => Value>
$playerAttributes->addCustomAttribute('location','Miami');
$playerAttributes->addCustomAttribute('graduationDate' , '2018-07-04T21:06:29.158Z');
$playerAttributes->addCustomAttribute('isMarried' , false);



$playerRequest =new \Gameball\Models\PlayerRequest();
$playerRequest->playerUniqueId='player456';
$playerRequest->playerAttributes= $playerAttributes;


$amount = '2500';
$transactionId ='tra_123456789';


$res= $gameball->transaction->rewardPoints($playerRequest,$amount ,$transactionId);
echo $res->body;


// Get Player Balance

// Example 1

$gameball = new \Gameball\GameballClient('API_KEY','TRANS_KEY');

$playerUniqueId = 'player456';


$res= $gameball->transaction->getPlayerBalance($playerUniqueId);
echo $res->body;




// Hold

// Example 1

$gameball = new \Gameball\GameballClient('API_KEY','TRANS_KEY');

$playerUniqueId ='player456';
$amount ='98.89';


$res= $gameball->transaction->holdPoints($playerUniqueId,$amount);
echo $res->body;




//Redeem

//Example 1

$gameball = new \Gameball\GameballClient('API_KEY','TRANS_KEY');


$redeemPointsRequest = new \Gameball\Models\RedeemPointsRequest();
$redeemPointsRequest->playerUniqueId = 'player456';
$redeemPointsRequest->holdReference = '2342452352435234';
$redeemPointsRequest->amount = '10';
$redeemPointsRequest->transactionId = 'tra_123456789';


$res= $gameball->transaction->redeemPoints($redeemPointsRequest);
echo $res->body;


// Reverse Trans

// Example 1

$gameball = new \Gameball\GameballClient('API_KEY','TRANS_KEY');

$playerUniqueId = 'player456';
$transactionId='1234567890';
$reversedTransactionId= '234567891';


$res= $gameball->transaction->reverseTransaction($playerUniqueId,$transactionId,$reversedTransactionId);
echo $res->body;



// Reverse Hold


// Example 1

$gameball = new \Gameball\GameballClient('API_KEY','TRANS_KEY');


$playerUniqueId = 'player456' ;
$holdReference ='9245fe4a-d402-451c-b9ed-9c1a04247482';


$res= $gameball->transaction->reverseHold($playerUniqueId,$holdReference);
echo $res->body;


//Action

//Example 1

$gameball = new \Gameball\GameballClient('API_KEY','TRANS_KEY');



$playerRequest =new \Gameball\Models\PlayerRequest();
$playerRequest->playerUniqueId='player123';


$amount = '99.98';
$transactionId ='tra_123456789';


$branch = \Gameball\Models\Branch::factory('bid123' , 'bname123');

$merchant = new \Gameball\Models\Merchant();
$merchant->uniqueId = 'mid123';
$merchant->name = 'mname123';
$merchant->branch = $branch;

$pointsTransaction = new \Gameball\Models\PointsTransaction();
$pointsTransaction->transactionId = $transactionId;
$pointsTransaction->rewardAmount = $amount;
$pointsTransaction->merchant = $merchant;


$actionRequest = new \Gameball\Models\ActionRequest();
$actionRequest->playerRequest = $playerRequest;
$actionRequest->pointsTransaction = $pointsTransaction;

$res= $gameball->action->sendAction($actionRequest);
echo $res->body;
