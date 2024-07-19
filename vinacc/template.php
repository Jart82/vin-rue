<?php 
$get_json = array();
$get_json['with'] = '{
	"heading": "Add Withdrawals",
	"details": "Create Withdrawals History",
	"mode": "new",
	"table": "withdrawals",
	"id": 0,
	"data": [ 
    {
		"name": "status",
		"label": "Status",
		"type": "select",
		"placeholder": "Select Status",
		"option": ["Pending", "Canceled", "Complete"]
	}
    ,{
		"name": "amount",
		"label": "Amount",
		"type": "number",
		"placeholder": "Enter Amount"
	},{
		"name": "wallet",
		"label": "Wallet",
		"type": "text",
		"placeholder": "Enter Wallet"
	},{
		"name": "address",
		"label": "Address",
		"type": "text",
		"placeholder": "Enter Address"
	},{
		"name": "currency",
		"label": "Currency",
		"type": "select",
		"placeholder": "Select Currency",
		"option": ["USD"]
	}, {
		"name": "reqdate",
		"label": "Request Date",
		"type": "datetime",
		"placeholder": "Enter date"
	},{
		"name": "paiddate",
		"label": "Paid Date",
		"type": "text",
		"placeholder": "Enter date"
	}, {
		"name": "refId",
		"label": "TRANS. ID",
		"type": "text",
		"placeholder": "TRANS. ID"
	} ]
}';
$obj = json_decode($get_json['with']);
$obj->mode = 'edit';
$get_json['with_edit'] = json_encode($obj);

$get_json['dep'] = '{
	"heading": "Add Deposits",
	"details": "Create Deposits History",
	"mode": "new",
	"table": "deposits",
	"id": 0,
	"data": [  {
		"name": "name",
		"label": "Fullname",
		"type": "text",
		"placeholder": "Enter Fullname"
	},{
		"name": "type",
		"label": "Type",
		"type": "select",
		"placeholder": "Select Type",
        "option": ["From Crypto", "Re-Invest"]
	},{
		"name": "duration",
		"label": "Duration",
		"type": "text",
		"placeholder": "Enter Duration"
	},{
		"name": "status",
		"label": "Status",
		"type": "select",
		"placeholder": "Select Status",
        "option": ["Unconfirmed", "Active", "Complete"]
	},{
		"name": "amount",
		"label": "Amount",
		"type": "number",
		"placeholder": "Enter Amount"
	},{
		"name": "currency",
		"label": "Currency",
		"type": "select",
		"placeholder": "Select Currency",
		"option": ["USD"]
	},  {
		"name": "refId",
		"label": "TRANS. ID",
		"type": "text",
		"placeholder": "TRANS. ID"
	}, {
		"name": "reldate",
		"label": "Release Date",
		"type": "datetime",
		"placeholder": "Enter Release date"
	},{
		"name": "date",
		"label": "Date",
		"type": "datetime",
		"placeholder": "Enter date"
	} ]
}';
$obj = json_decode($get_json['dep']);
$obj->mode = 'edit';
$get_json['dep_edit'] = json_encode($obj);


$get_json['plans'] = '{
    "heading": "Add Plans",
    "details": "Create Plan Listing",
    "mode": "new",
    "table": "plans",
    "id": 0,
    "data": [
        {
            "name": "min",
            "label": "Minimum Investment",
            "type": "number",
            "placeholder": "Enter Amount"
        },
        {
            "name": "minprofit",
            "label": "Minimum Expected Profit",
            "type": "number",
            "placeholder": "Enter Expected Profit"
        },
        {
            "name": "maxprofit",
            "label": "Maximum Expected Profit",
            "type": "number",
            "placeholder": "Enter Expected Profit"
        },
        {
            "name": "plan",
            "label": "Plan Name",
            "type": "text",
            "placeholder": "Enter eg Bronze Plan"
        },
        {
            "name": "duration",
            "label": "Duration",
            "type": "text",
            "placeholder": "Enter eg 3 Days"
        }
    ]
}';
$obj = json_decode($get_json['plans']);
$obj->mode = 'edit';
$get_json['plans_edit'] = json_encode($obj);


$get_json['earn'] = '{
    "heading": "Add Earnings",
    "details": "Create Earn Listing",
    "mode": "new",
    "table": "earnings",
    "id": 0,
    "data": [
        {
            "name": "amount",
            "label": "Investment Amount",
            "type": "number",
            "placeholder": "Enter Amount"
        },
        {
		"name": "currency",
		"label": "Currency",
		"type": "select",
		"placeholder": "Select Currency",
		"option": ["USD"]
	    },
        {
            "name": "wallet",
            "label": "Source",
            "type": "text",
            "placeholder": "Enter Expected Profit"
        },
        {
            "name": "status",
            "label": "Status",
            "type": "text",
            "placeholder": "Enter Status"
        },
        {
            "name": "date",
            "label": "Earning Date",
            "type": "datetime",
            "placeholder": "Enter Earning Date"
        }
    ]
}';
$obj = json_decode($get_json['earn']);
$obj->mode = 'edit';
$get_json['earn_edit'] = json_encode($obj);
?>