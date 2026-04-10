// Create a jquery plugin that prints the given element.
jQuery.fn.print = function(){
// NOTE: We are trimming the jQuery collection down to the
// first element in the collection.
if (this.size() > 1){
this.eq( 0 ).print();
return;
} else if (!this.size()){
return;
}
 
// ASSERT: At this point, we know that the current jQuery
// collection (as defined by THIS), contains only one
// printable element.
 
// Create a random name for the print frame.
var strFrameName = ("printer-" + (new Date()).getTime());
 
// Create an iFrame with the new name.
var jFrame = $( "<iframe name='" + strFrameName + "'>" );
 
// Hide the frame (sort of) and attach to the body.
jFrame
.css( "width", "1px" )
.css( "height", "1px" )
.css( "position", "absolute" )
.css( "left", "-9999px" )
.appendTo( $( "body:first" ) )
;
 
// Get a FRAMES reference to the new frame.
var objFrame = window.frames[ strFrameName ];
 
// Get a reference to the DOM in the new frame.
var objDoc = objFrame.document;
 
// Grab all the style tags and copy to the new
// document so that we capture look and feel of
// the current document.
 
// Create a temp document DIV to hold the style tags.
// This is the only way I could find to get the style
// tags into IE.
var jStyleDiv = $( "<div>" ).append(
$( "style" ).clone()
);
 
// Write the HTML for the document. In this, we will
// write out the HTML of the current element.
objDoc.open();
objDoc.write( "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">" );
objDoc.write( "<html>" );
objDoc.write( "<body>" );
objDoc.write( "<head>" );
objDoc.write( "<title>" );
objDoc.write( document.title );
objDoc.write( "</title>" );
objDoc.write( jStyleDiv.html() );
objDoc.write( "</head>" );
objDoc.write( this.html() );
objDoc.write( "</body>" );
objDoc.write( "</html>" );
objDoc.close();
 
// Print the document.
objFrame.focus();
objFrame.print();
 
// Have the frame remove itself in about a minute so that
// we don't build up too many of these frames.
setTimeout(
function(){
jFrame.remove();
},
(60 * 1000)
);
}


mrcdiv


var storeval = store.value;

				if(storeval=="1")
                 {
                 $('#savebutton').text('Save');
                 $("#myToast").toast({ delay: 10000 });
                 $("#myToast").toast('show');
				 $('#toast-massages').html("Invalid Store Selection");
                 $( '#store-error' ).html('Invalid Store Selection');
                 $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                 }
				 
				 CustomerMRC
				 
				 
	 var cust = customer.value;
    var storeval = store.value;
    var voucherTypeVal=voucherType.value; 
    var CustomerMRCVal=CustomerMRC.value;			 
	
	 if(cust=="1")
                 {
                 $('#savebutton').text('Save');
                 $("#myToast").toast({ delay: 10000 });
                 $("#myToast").toast('show');
                 $('#toast-massages').html("Invalid customer Selection");
                 $( '#customer-error' ).html("Invalid customer Selection");
                 $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                 }

                 if(storeval=="1")
                 {
                 $('#savebutton').text('Save');
                 $("#myToast").toast({ delay: 10000 });
                 $("#myToast").toast('show');
                 $('#toast-massages').html("Invalid Store Selection");
                 $( '#store-error' ).html('Invalid Store Selection');
                 $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
                 }
				 
				 
				  if(voucherTypeVal=="Fiscal-Receipt" &&  CustomerMRCVal=="--")
                {
                
                $("#myToast").toast({ delay: 10000 });
                $("#myToast").toast('show');
                $('#toast-massages').html("Invalid Mrc Selection");
                $( '#CustomerMRC-error' ).html('For Fiscal Reciept MRC Is Required');
                $('.toast-body').css({"background-color": "  #dc3545","color":"white", "font-weight": "bold","font-size":"15px","border-radius":"15px"});
            
                    

                }
				
				 'CustomerMRC'=>trim($request->CustomerMRC),
				 
				 
				 
	$("#dynamicTable").empty();
    $("#dynamicTable").append('<tr><th style="width:3%;">#</th><th>Item Name</th><th style="width:10%">Type</th><th>Quantity</th> <th>Unit Price</th><th>Discount</th><th>Before Tax</th> <th>Tax Amount</th> <th>Total Cost</th><th></th>');
          
		   var storeval = store.value;