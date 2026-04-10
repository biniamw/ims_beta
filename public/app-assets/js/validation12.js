
//--------------------------CUSTOMER VALIDATION STARTS-------------------------
//Only Number Validation
function ValidateOnlyNum(event) 
{
    var regex = new RegExp("^[0-9]");
    var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) 
	{
        event.preventDefault();
        return false;
    }
}

//Count Tin Numbers
 function countTinChar(val) 
 {
    var len = val.value.length;
    if (len == 10 || len == 13||len==0) 
	{
		$( '#tin-error' ).html( "" );
    }
    else 
	{
		$( '#tin-error' ).html( "TIN should be 10 or 13 character" );
    }
}

//Validate MRC Number
function ValidateMrc(event) 
{
    var regex = new RegExp("^[0-9/a-z/A-Z]");
    var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) 
	{
        event.preventDefault();
        return false;
    }
}

//Count MRC Input
function countMrcChar(val) 
{
    var len = val.value.length;
    var mrcValue;
    mrcValue = document.getElementById("mrc-number").value.toUpperCase();
    document.getElementById("mrc-number").value = mrcValue;
    if (len == 10 || len == 0) 
	{
		$( '#mrc-error' ).html( "" );
    }
    else 
	{
		$( '#mrc-error' ).html( "MRC should be 10 character" );

     }
}

//Validate Phone
 function ValidatePhone(event) 
 {
    var regex = new RegExp("^[0-9+/-]");
    var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) 
	{
        event.preventDefault();
        return false;
    }
}

//Validate Email
function ValidateEmail() 
{
    var email = document.getElementById("EmailAddress").value;
    $( '#email-error' ).html( "" );
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (!expr.test(email)) 
	{
		$( '#email-error' ).html( "Invalid Email Address" );  
    }
}

//Validate Website
 function ValidateWebsite(val) 
 {
    var len = val.value.length;
    if (len == 0) 
	{
		$( '#website-error' ).html( "" );
    }
    else 
	{
        var website = document.getElementById("Website").value;
        $( '#Website-error' ).html( "" );
        var expr = /^([\w-\.]+).((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (!expr.test(website)) 
		{
			$( '#Website-error' ).html( "Invalid Website Address" );
        }
    }
}
//--------------------------CUSTOMER VALIDATION ENDS-------------------------