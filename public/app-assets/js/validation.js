
//--------------------------CUSTOMER VALIDATION STARTS-------------------------
//Only Number Validation
function ValidateOnlyNum(event) {
    var regex = new RegExp("^[0-9]");
    var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
}

//Count Tin Numbers
function countTinChar(val) {
    var len = val.value.length;
    if (len == 10 || len == 13 || len == 0) {
        $('#tin-error').html("");
        $('#bltin-error').html("");
    }
    else {
        $('#tin-error').html("TIN should be 10 or 13 character");
        $('#bltin-error').html("TIN should be 10 or 13 character");
    }
}

//Count barcode Numbers
function countBarcode(val) {
    var len = val.value.length;
    if (len == 12 || len == 13) {
        $('#skuNumber-error').html("");
    }
    else {
        $('#skuNumber-error').html("Sku Number be 12 or 13 character");

    }
}

//Validate MRC Number
function ValidateMrc(event) {
    var regex = new RegExp("^[0-9/a-z/A-Z]");
    var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
}

//Count MRC Input
function countMrcChar(val) {
    var len = val.value.length;
    var mrcValue;
    mrcValue = document.getElementById("MRCNumber").value.toUpperCase();
    document.getElementById("MRCNumber").value = mrcValue;
    if (len == 10 || len == 0) {
        $('#mrc-error').html("");
    }
    else {
        $('#mrc-error').html("MRC should be 10 character");

    }
}
function countAddMrcChar(val) {
    var len = val.value.length;
    var mrcValue;
    mrcValue = document.getElementById("MrcNumber").value.toUpperCase();
    document.getElementById("MrcNumber").value = mrcValue;
    if (len == 10 || len == 0) {
        $('#mname-error').html("");
    }
    else {
        $('#mname-error').html("MRC should be 10 character");
    }
}
function countAddEdMrcChar(val) {
    var len = val.value.length;
    var mrcValue;
    mrcValue = document.getElementById("mrcnumber").value.toUpperCase();
    document.getElementById("mrcnumber").value = mrcValue;
    if (len == 10 || len == 0) {
        $('#muname-error').html("");
    }
    else {
        $('#muname-error').html("MRC should be 10 character");

    }
}
//Validate Phone
function ValidatePhone(event) {
    var regex = new RegExp("^[0-9+/-]");
    var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
}

//Validate Email
function ValidateEmail() {
    var email = document.getElementById("EmailAddress").value;
    $('#email-error').html("");
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (!expr.test(email)) {
        $('#email-error').html("Invalid Email Address");
    }
}
//Validate Blacklist Email
function ValidateBlEmail() {
    var email = document.getElementById("blEmailAddress").value;
    $('#blemail-error').html("");
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (!expr.test(email)) {
        $('#blemail-error').html("Invalid Email Address");
    }
}
//Validate Website
function ValidateWebsite(val) {
    var len = val.value.length;
    if (len == 0) {
        $('#website-error').html("");
    }
    else {
        var website = document.getElementById("Website").value;
        $('#Website-error').html("");
        var expr = /^([\w-\.]+).((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (!expr.test(website)) {
            $('#Website-error').html("Invalid Website Address");
        }
    }
}

//Validate Blacklist Website
function ValidateBlWebsite(val) {
    var len = val.value.length;
    if (len == 0) {
        $('#blWebsite-error').html("");
    }
    else {
        var website = document.getElementById("blWebsite").value;
        $('#blWebsite-error').html("");
        var expr = /^([\w-\.]+).((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (!expr.test(website)) {
            $('#blWebsite-error').html("Invalid Website Address");
        }
    }
}
//--------------------------CUSTOMER VALIDATION ENDS-------------------------


//-----------------------ITEM VALIDATION STARTS-----------------------------

function ValidateNum(event) {
    var regex = new RegExp("^[0-9/.]");
    var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
}

function ValidateCode(event) {
    var regex = new RegExp("^[0-9/a-z/A-Z/-]");
    var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
}

function ValidateNumbers(event) {
    var regex = new RegExp("^[0-9]");
    var key = String.fromCharCode(event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
}

//-----------------------------------------ITEM VALIDATION ENDS------------------------------