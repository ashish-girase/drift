<?php
namespace App\Helpers;
use App\Models\Shipper;
use Auth;
use App\Models\FuelCard;
use App\Models\IftaCardCategory;
use App\Models\FuelVendor;
use App\Models\Owner_operator_driver;
use App\Models\Driver;
use App\Models\traileradd;
use App\Models\TrailerAdminAdd;
use App\Models\UserSubscription;
use App\Models\Factoring_company_add;
use App\Models\bank_debit_category;
use App\Models\PaymentBank;
use App\Models\Payment_terms;
use App\Models\Currency_add;
use App\Models\CreditCardAdmin;
use App\Models\Company;
use App\Models\tokenHandle;
use App\Models\Carrier;
use App\Models\User;
use App\Models\Bank;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Department;
use App\Models\LoggedUsers;

class AppHelper
{
    public function getNextSequenceForNewDoc( $collection)//w
    {
        $maxId = $collection->aggregate([
            ['$group' => ['_id' => null, 'max_id' => ['$max' => '$_id']]],
        ])->toArray();

        if (!empty($maxId)) {
            $maxId = $maxId[0]['max_id'];
            // dd( $maxId);
            $parentId = $maxId + 1;
        } else {
            $parentId = 1; // If no documents found for the company, start with 1
        }

        return $parentId;
    }
    public function getMasterDocumentSequence($key,$collection,$val)
{
$cursor = $collection->aggregate([
['$match' => ['companyID' => (int)$key]],
['$sort' => ['_id' => -1]],
['$limit'=>1],
['$unwind' => '$'.$val],
['$sort' => [$val.'._id'=> -1]],
['$limit'=>1],
['$project' => [$val.'._id'=>1]],
]);

$lastID = 0;
foreach($cursor as $c1)
{
$xs = 0;
$crr[$xs] = $c1[$val];
$xs++;
foreach($crr as $l1)
{
$lastID = $l1['_id'];
}
}

$lastID += 1;
$collection->updateOne(['companyID' => (int)$key],
['$inc' => ['counter' => 1]]);
return $lastID;
}


// particular object counter Increment
function getDocumentSequenceId($type,$collection1,$arrayName,$companyid)
{
$cursor = $collection1->find(['companyID' => $companyid],[
$arrayName => ['$elemMatch' => ['_id' => (int)$type]]
]);
$array = iterator_to_array($cursor);
$id = 0;
foreach ($array as $value)
{
$counterID = $value[$arrayName];
foreach ($counterID as $row)
{
if((int)$type == $row['_id'])
{
$id = $row['counter'];
}
}
}
$id += 1;
$collection1->updateOne(['companyID'=>$companyid,$arrayName.'_id' => (int)$type],['$set'=>[$arrayName.'$.counter'=>$id]]);
return $id;
}

// particular object counter Decrement
function getDocumentDecrementId($type,$collection2,$arrayName,$companyid)
{
$cursor = $collection2->find(['companyID' => $companyid],[
$arrayName => ['$elemMatch' => ['_id' => (int)$type]]
]);
$array = iterator_to_array($cursor);
$id = 0;
foreach ($array as $value)
{
$counterID = $value[$arrayName];
foreach ($counterID as $row)
{
if((int)$type == $row['_id'])
{
$id = $row['counter'];
}
}
}
$id -= 1;
$collection2->updateOne(['companyID'=>1,$arrayName.'_id' => (int)$type],['$set'=>[$arrayName.'$.counter'=>$id]]);
return $id;
}

public function checkDoc($collection,$companyId,$maxLength)
{
$show = $collection->count(['companyID' => (int)$companyId]);
if($show != 0){
$show = $collection->aggregate([
['$match' => ['companyID' => (int)$companyId]],
['$sort' => ['_id' => -1]],
['$limit' => 1]
]);
foreach ($show as $s1){
$doc_id = $s1['_id'];
$ncounter = $s1['counter'];
}
if($ncounter >= $maxLength){
$document = "No";
}else{
$document = $ncounter ."^". $doc_id;
}
// dd($document);

}else{
$document = "No";
}
return $document;
}
function getAdminDocumentSequence($key,$collection,$val, $docId)
{
$cursor = $collection->find(['companyID'=>(int)$key, '_id' => (int)$docId]);
$array = iterator_to_array($cursor);
$id = 0;
foreach ($array as $value)
{
$counter = $value['counter'];
foreach ($value[$val] as $arr)
{
if(isset($arr['_id']))
{
$id = $arr['_id'];
}
}
}
$id += 1;
$collection->updateOne(['companyID' => (int)$key,'_id'=>(int)$docId],
['$inc' => ['counter' => 1]]);
return $id;
}
public function oodriverinstallment($isownoptr,$daterangefrom,$daterangeto,$drrecurrid)
{
if ($isownoptr == "YES")
{
$daterangeto1 = (int)$daterangeto;
$daterangefrom1 = (int)$daterangefrom;

$collection_oo = Owner_operator_driver::raw();
$ownerdrivername = $collection_oo->aggregate([
['$match'=>['companyID'=> (int)Auth::user()->companyID]],
['$unwind'=> '$ownerOperator'],
['$match' => ['ownerOperator.driverId' => ['$in' => [$drrecurrid]]]]
]);

$oorecurrencesubList = array();
foreach ($ownerdrivername as $ooval)
{
$o = 0;
$ooarr[$o] = $ooval['ownerOperator'];
$o++;
foreach ($ooarr as $ownerval)
{
$ooid = $ownerval['_id'];
$oodriverId = $ownerval['driverId'];
$oopercentage = $ownerval['percentage'];
$ootruckNo = $ownerval['truckNo'];
$ooinstallment = $ownerval['installment'];
foreach ($ooinstallment as $ooins)
{

if ($ooins['installmentCategory'] != "")
{
$ins_id = $ooins['_id'];
$ins_installmentCategory = $ooins['installmentCategory'];
$ins_installmentType = $ooins['installmentType'];
$ins_amount = $ooins['amount'];
$ins_installment = $ooins['installment'];
$ins_startNo = $ooins['startNo'];
$ins_startDate = $ooins['startDate'];
$ins_internalNote = $ooins['internalNote'];
$ooskipped = array();
if(array_key_exists("skiprecurrence", array($ooins)))
{
$ooskipped = $ooins['skiprecurrence'];
}

$insrecurrence_addsub = "sub";
$id=$ins_id;
$category=$ins_installmentCategory;
$type=$ins_installmentType;
$amount=$ins_amount;
$total_install=$ins_installment;
$start_install=$ins_startNo;
$startdate=$ins_startDate;
$internalnote=$ins_internalNote;
$recurrtype=$insrecurrence_addsub;
$to=$daterangeto1;
$from=$daterangefrom1;
$skipped=$ooskipped;

$seconds = 604800;
if($type == "Monthly")
{
$seconds = 2592000;
}
if($type == "Quarterly")
{
$seconds = 7776000;
}
if($type == "yearly")
{
$seconds = 31536000;
}
$skipped_installment = sizeof($skipped);
$skip_arr = array();
for($i = 0; $i < $skipped_installment; $i++)
{
$skip_arr[$skipped[$i]['recurrenceno']] = $skipped[$i]['recurrencedate'];
}

$enddate = $startdate + ($total_install * $seconds) + ($skipped_installment * $seconds);

$recurrence = array();
$totalamount = 0;
if($from < $enddate)
{
$dateDiff = $from - $startdate;
$weeks = ceil($dateDiff / $seconds) - $skipped_installment;
$no = $start_install;
$no += $weeks;
for($i = $start_install,$j = 0; $i < $total_install + $skipped_installment; $i++,$j++)
{
if($i == 0)
{
$start = $startdate;
}
else
{
$start = $startdate + ($j * $seconds);
}
$recurrencetotalam = 0;
if($start <= $to && $start >= $from)
{
if(array_key_exists($i, $skip_arr)){
$recurrence[] = array("id"=>$id,"no" => $no, "amount" => (float)$amount,"date" => date('m/d/Y', $start),"category"=>$category, "type" => $type, "note" => $internalnote,"recurrtype" => $recurrtype, "skipped" => "yes");
$no++;
}
else
{
$recurrencetotalam += $amount;
$recurrence[] = array("id"=>$id,"no" => $no, "amount" => (float)$amount,"date" => date('m/d/Y', $start),"category"=>$category, "type" => $type, "note" => $internalnote,"recurrtype" => $recurrtype, "skipped" => "no");
$no++;
}
}
}
}
$oorecurrencesubList[] = $recurrence;

}

}
}
}
return $oorecurrencesubList;
}

}
public function driverinstallment($id, $category, $type, $amount, $total_install, $start_install, $startdate, $internalnote, $recurrtype, $to, $from, $skipped)
{
$seconds = 604800;
if($type == "Monthly")
{
$seconds = 2592000;
}
if($type == "Quarterly")
{
$seconds = 7776000;
}
if($type == "yearly")
{
$seconds = 31536000;
}
$skipped_installment = sizeof($skipped);
$skip_arr = array();
for($i = 0; $i < $skipped_installment; $i++)
{
$skip_arr[$skipped[$i]['recurrenceno']] = $skipped[$i]['recurrencedate'];
}
$enddate = intval($startdate) + (intval($total_install) * intval($seconds)) + (intval($skipped_installment) * intval($seconds));
$recurrence = array();
$totalamount = 0;
if($from < $enddate)
{
$dateDiff = $from - $startdate;
$weeks = ceil($dateDiff / $seconds) - $skipped_installment;
$no = $start_install;
$no += $weeks;
for($i = $start_install,$j = 0; $i < $total_install + $skipped_installment; $i++,$j++)
{
if($i == 0)
{
$start = $startdate;
}
else
{
$start = $startdate + ($j * $seconds);
}
$recurrencetotalam = 0;
if($start <= $to && $start >= $from)
{
if(array_key_exists($i, $skip_arr))
{
$recurrence[] = array("id"=>$id,"no" => $no, "amount" => (float)$amount,"date" => date('m/d/Y', $start),"category"=>$category, "type" => $type, "note" => $internalnote,"recurrtype" => $recurrtype, "skipped" => "yes");
$no++;
}
else
{
$recurrencetotalam += $amount;
$recurrence[] = array("id"=>$id,"no" => $no, "amount" => (float)$amount,"date" => date('m/d/Y', $start),"category"=>$category, "type" => $type, "note" => $internalnote,"recurrtype" => $recurrtype, "skipped" => "no");
$no++;
}
}
}
}

return $recurrence;

}
function traileTyperArray($trailerid)
{
$trailerdata = traileradd::raw()->aggregate([
['$match' => ['companyID' => (int)Auth::user()->companyID]],
['$unwind' => '$trailer'],
['$match' => ['trailer._id' => (int)$trailerid]],
['$project' => ['trailer._id' => 1, 'trailer.trailerType' => 1]]
]);
$trailerarray = array();
foreach ($trailerdata as $c)
{
$h = 0;
$trailerarray[$h] = $c['trailer'];
$h++;
foreach ($trailerarray as $cr)
{
$trailerid = $cr['_id'];
$trailername[$trailerid] = $cr['trailerType'];
}
}
return $trailername;
}

function truckTypekarr($truckid)
{
$truckdata = traileradd::raw()->aggregate([
['$match' => ['companyID' => (int)Auth::user()->companyID]],
['$unwind' => '$truck'],
['$match' => ['truck._id' => (int)$truckid]],
['$project' => ['truck._id' => 1, 'truck.truckType' => 1]]
]);
$truckarray = array();
foreach ($truckdata as $c)
{
$h = 0;
$truckarray[$h] = $c['truck'];
$h++;
foreach ($truckarray as $cr)
{
$truckid = $cr['_id'];
$truckname[$truckid] = $cr['truckType'];
}
}
return $truckname;
}

function currencyTypeArray($cid)
{
$crrdata = Currency_add::raw()->aggregate([
['$match' => ['companyID' => (int)Auth::user()->companyID]],
['$unwind' => '$currency'],
['$match' => ['currency._id' => (int)$cid]],
['$project' => ['currency._id' => 1, 'currency.currencyType' => 1]]
]);
$currencyarray = array();
foreach ($crrdata as $c) {
$h = 0;
$currencyarray[$h] = $c['currency'];
$h++;
foreach ($currencyarray as $cr) {
$cuid = $cr['_id'];
$currencyname[$cuid] = $cr['currencyType'];
}
}
return $currencyname;
}

function paymentTermsArray($pid)
{
$paydata = Payment_terms::raw()->aggregate([
['$match' => ['companyID' => (int)Auth::user()->companyID]],
['$unwind' => '$payment'],
['$match' => ['payment._id' => (int)$pid]],
['$project' => ['payment._id' => 1, 'payment.paymentTerm' => 1]]
]);
$paymentarray = array();
foreach ($paydata as $c) {
$h = 0;
$paymentarray[$h] = $c['payment'];
$h++;
foreach ($paymentarray as $cr) {
$payid = $cr['_id'];
$paymentname[$payid] = $cr['paymentTerm'];
}
}
return $paymentname;
}
public function getRemainingEntry($data)
{
$plan = $data['planname'];
$collection = UserSubscription::raw();
$show1 = $collection->aggregate([
['$match' => ['companyID' => (int)Auth::user()->companyID]],
['$unwind' => '$addon'],
['$match' => ['addon.planname' => $plan]],
['$project' => ['addon.planname' => 1,'addon.counter' => 1]]
]);
$remaining = 0;
foreach($show1 as $s1)
{
$k = 0;
$ss1[$k] = $s1['addon'];
$k++;
foreach($ss1 as $s2)
{
$remaining = $s2['counter'];
}
}
echo $remaining;
}
public function incrementSubscriptionCounter($planname, $planId, $fname)
{
if (UserSubscription::raw()->updateOne(['companyID' => (int)Auth::user()->companyID, $planname.'.planID' => (string)$planId],
['$inc' => [$planname.'.'.$fname => 1]])) {
return true;
} else {
return false;
}
}
public function decrementSubscriptionCounter($planname, $planId, $fname)
{
if(UserSubscription::raw()->updateOne(['companyID' => (int)Auth::user()->companyID, $planname.'.planID' => (string)$planId],
['$inc' => [$planname.'.'.$fname => -1]]))
{
return true;
}
else
{
return false;
}
}
function factoringArray($factid,$parent)
{
$factdata = Factoring_company_add::raw()->aggregate([
['$match' => ['companyID' => (int)Auth::user()->companyID,'_id'=>(int)$parent]],
['$unwind' => '$factoring'],
['$match' => ['factoring._id' => (int)$factid]],
['$project' => ['factoring._id' => 1, 'factoring.factoringCompanyname' => 1]]
]);
$factarray = array();
$factname = array();
foreach ($factdata as $c)
{
$h = 0;
$factarray[$h] = $c['factoring'];
$h++;
foreach ($factarray as $cr)
{
$factid = $cr['_id'];
$factname[$parent."-".$factid] = $cr['factoringCompanyname'];
}
}
return $factname;
}
function adminCreditCardArray($acid)
{
$creditdata = CreditCardAdmin::raw()->aggregate([
['$match' => ['companyID' => (int)Auth::user()->companyID]],
['$unwind' => '$admin_credit'],
['$match' => ['admin_credit._id' => (int)$acid]],
['$project' => ['admin_credit._id' => 1, 'admin_credit.displayName' => 1]]
]);
$creditarray = array();
foreach ($creditdata as $c)
{
$h = 0;
$creditarray[$h] = $c['admin_credit'];
$h++;
foreach ($creditarray as $cr)
{
$cid = $cr['_id'];
$creditCardname[$cid] = $cr['displayName'];
}
}
return $creditCardname;
}
function companyArray($comid)
{
$comdata = Company::raw()->aggregate([
['$match' => ['companyID' => (int)Auth::user()->companyID]],
['$unwind' => '$company'],
['$match' => ['company._id' => (int)$comid]],
['$project' => ['company._id' => 1, 'company.companyName' => 1]]
]);

$companyarray = array();
foreach ($comdata as $c)
{
$h = 0;
$companyarray[$h] = $c['company'];
$h++;
foreach ($companyarray as $cr)
{
$companyid = $cr['_id'];
$companyname[$companyid] = $cr['companyName'];
}
}
return $companyname;
}
public function remainingItems($planname, $planId, $remaining)
{
$truck = UserSubscription::raw()->findOne(['companyID' => (int)Auth::user()->companyID, $planname.'.planID' => (string)$planId]);
if ($truck[$planname][$remaining] <= 0 )
{
return false;
}
else
{
return true;
}
}

public function getRemainCounter($planId)
{
$getData = UserSubscription::raw()->aggregate([
['$match' => ['companyID' => (int)Auth::user()->companyID]],
['$unwind' => '$addon'],
['$match' => ['addon.planID' => $planId]],
['$project' => ['addon.counter' => 1]]
]);
foreach($getData as $d)
{
$counter = $d['addon']['counter'];
}
if($counter > 0)
{
return true;
}
else
{
return false;
}
}

public function decrementAddonQty($planId, $count = 1)
{
if (UserSubscription::raw()->updateOne(['companyID' => (int)Auth::user()->companyID, 'addon.planID' => (string)$planId],
['$inc' => ['addon.$.counter' => -$count]]))
{
return true;
}
else
{
return false;
}
}
function getDocumentSequence($key,$collection)
{

$cursor = $collection->find(['companyID'=>(int)$key]);
$array = iterator_to_array($cursor);
$id = 0;
foreach ($array as $value)
{
$id = $value['counter'];
}
$id += 1;
$collection->findOneAndUpdate(['companyID'=>(int)$key],['$set'=>['counter'=>$id]]);

return $id;
}
public function updateTokenStatusFromDatabase($token, $collection, $cid, $status, $tokenCol = 'token', $statusCol = 'status', $checkTime = '')
{
if($this->checkTokenStatus($cid, $collection, $token, $tokenCol, $statusCol)) {
$timeField = ($checkTime != '') ? $checkTime : ($status == 'Open' ? 'openTime' : 'completedTime');
if (tokenHandle::raw()->updateOne(
['companyId' => (int)$cid, $collection.'.'.$tokenCol => $token],
['$set' => [$collection.'.$.'.$statusCol => $status, $collection.'.$.'.$timeField => time()]]
))
{
return true;
}
else
{
return false;
}
}
else
{
return false;
}
}
public function checkTokenStatus( $cid, $collection, $token, $tokenCol, $statusCol)
{
$res = tokenHandle::raw()->aggregate([
['$match' => ['companyId' => (int)$cid]],
['$unwind' => '$'.$collection],
['$match' => [$collection.'.'.$tokenCol => $token]],
['$project' => [$collection.'.'.$statusCol => 1]]
]);
$status = '';
foreach ($res as $r)
{
$status = $r[$collection][$statusCol];
}

if ($status == 'Completed')
{
return false;
}
else
{
return true;
}
}
public function getDocument($data, $length, $maxLength, $counter)
{
// dd($data);
// dd(gettype($data));
// if(gettype($data)=="array")
// {
// $data=get_object_vars((object)$data);
// }
$data=json_decode($data);
// dd($data);
if ($counter < $maxLength)
{
$blank_space = $maxLength - $counter;
}
if($blank_space >= $length)
{
for ($i = 0; $i < sizeof($data); $i++)
{
// dd((int)$data[$i]->counter);
if(!isset($data[$i]->counter)){
$dataCounter=0;
}else{
$dataCounter=$data[$i]->counter;
}
$data[$i]->_id = (int)$data[$i]->_id;
// $data[$i]->counter = (int) $data[$i]->counter;
$data[$i]->counter = (int) $dataCounter;
if(array_key_exists('amount',array($data[$i])))
{
// dd($data[$i]->amount);
$data[$i]->amount =(float)$data[$i]->amount;
}
if(array_key_exists('totalAmount',array($data[$i])))
{
$data[$i]->totalAmount= (float) $data[$i]->totalAmount;
}
if(array_key_exists('transactionDate',array($data[$i])))
{
$data[$i]->transactionDate = strtotime($data[$i]->transactionDate);
}
if(array_key_exists('tollDate',array($data[$i])))
{
$data[$i]->tollDate = (int)strtotime($data[$i]->tollDate);
}
}
$arrData[] = $data;
$arrData[] = "";
if($length > 100 )
{
$lastentry[] = array_slice($arrData[0],$length-100,$length);
}
else
{
$lastentry[] = $arrData[0];
}
}
else
{
$arrData[] = array_slice($data,0,$blank_space);
for($c = 0 ; $c < sizeof($arrData[0]); $c++)
{
$arrData[0][$c]['_id'] = (int)$arrData[0][$c]['_id'];
$arrData[0][$c]['counter'] =(int)$arrData[0][$c]['counter'];
if(array_key_exists('amount',$arrData[0][$c]))
{
$arrData[0][$c]['amount'] = (float)$arrData[0][$c]['amount'];
}
if(array_key_exists('totalAmount',$arrData[0][$c]))
{
$arrData[0][$c]['totalAmount'] = (float)$arrData[0][$c]['totalAmount'];
}
if(array_key_exists('transactionDate',$arrData[0][$c]))
{
$arrData[0][$c]['transactionDate'] = strtotime($arrData[0][$c]['transactionDate']);
}
if(array_key_exists('tollDate',$arrData[0][$c]))
{
$arrData[0][$c]['tollDate'] = (int)strtotime($arrData[0][$c]['tollDate']);
}
}
$arrData[] = array_slice($data,$blank_space,$length);
for($c = 0 ; $c < sizeof($arrData[1]); $c++)
{
$arrData[1][$c]['_id'] = $c;
$arrData[1][$c]['counter'] = 0;
if(array_key_exists('amount',$arrData[1][$c]))
{
$arrData[1][$c]['amount'] = (float)$arrData[1][$c]['amount'];
}
if(array_key_exists('totalAmount',$arrData[1][$c]))
{
$arrData[1][$c]['totalAmount'] = (float)$arrData[1][$c]['totalAmount'];
}
if(array_key_exists('transactionDate',$arrData[1][$c]))
{
$arrData[1][$c]['transactionDate'] = strtotime($arrData[1][$c]['transactionDate']);
}
if(array_key_exists('tollDate',$arrData[1][$c]))
{
$arrData[1][$c]['tollDate'] = (int)strtotime($arrData[1][$c]['tollDate']);
}
}

$sizeDoc1 = sizeof($arrData[0]);
$sizeDoc2 = sizeof($arrData[1]);

if($sizeDoc2 > 100)
{
$lastentry[] = "";
$lastentry[] = array_slice($arrData[1],$sizeDoc2-100,$sizeDoc2);
}
else
{
if($sizeDoc1 + $sizeDoc2 <= 100)
{
$lastentry[] = $arrData[0];
$lastentry[] = $arrData[1];
}
else
{
$e1 = 100 - $sizeDoc2;
$e2 = $sizeDoc1 - $e1;
$a1 = array_slice($arrData[0],$e2,$sizeDoc1);
$a2 = $arrData[1];
$lastentry[] = $a1;
$lastentry[] = $a2;
}
}
}
$arrData1 = array(
'arrData' => $arrData,
'lastarray' => $lastentry
);
return $arrData1;
}
public function getIntId($name,$collection)
{
$id=(int)1;
return $id;
}
public function showQueries()
{
dd(\DB::getQueryLog());
}

public static function instance()
{
return new AppHelper();
}

function getBankarr($bankid)
{
$bank_admin = Bank::raw();
$companyID = (int)Auth::user()->companyID;
$bankdata = $bank_admin->aggregate([
['$match' => ['companyID' => (int)$companyID]],
['$unwind' => '$admin_bank'],
['$match' => ['admin_bank._id' => (int)$bankid]],
['$project' => ['admin_bank._id' => 1, 'admin_bank.bankName' => 1]]
]);
$bankarray = array();
foreach ($bankdata as $c) {
$h = 0;
$bankarray[$h] = $c['admin_bank'];
$h++;
foreach ($bankarray as $cr) {
$bankid = $cr['_id'];
$bankname[$bankid] = $cr['bankName'];
}
}
return $bankname;
}

function getDebitarr($debitid)
{
$companyID = (int)Auth::user()->companyID;
$debitdata = bank_debit_category::raw()->aggregate([
['$match' => ['companyID' => (int)$companyID]],
['$unwind' => '$bank_debit'],
['$match' => ['bank_debit._id' => (int)$debitid]],
['$project' => ['bank_debit._id' => 1, 'bank_debit.bankName' => 1]]
]);
$debitarray = array();
foreach ($debitdata as $c) {
$h = 0;
$debitarray[$h] = $c['bank_debit'];
$h++;
foreach ($debitarray as $cr) {
$debitid = $cr['_id'];
$debitname[$debitid] = $cr['bankName'];
}
}
return $debitname;
}


}
