/* The following function creates an XMLHttpRequest object... */

function createRequestObject(){
	var request_o; //declare the variable to hold the object.
	var browser = navigator.appName; //find the browser name
	if(browser == "Microsoft Internet Explorer"){
		/* Create the object using MSIE's method */
		request_o = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		/* Create the object using other browser's method */
		request_o = new XMLHttpRequest();
	}
	return request_o; //return the object
}

/* You can get more specific with version information by using 
	parseInt(navigator.appVersion)
	Which will extract an integer value containing the version 
	of the browser being used.
*/
/* The variable http will hold our new XMLHttpRequest object. */
var http = createRequestObject(); 

/* Function called to get the product categories list */
function getProducts(){
	/* Create the request. The first argument to the open function is the method (POST/GET),
		and the second argument is the url... 
		document contains references to all items on the page
		We can reference document.form_category_select.select_category_select and we will 		
		be referencing the dropdown list. The selectedIndex property will give us the 
		index of the selected item. 
	*/
//	alert(document.searchBy.vid.selectedIndex);
	http.open('get', './includes/internal_request.php?action=get_products&id=' 
			+ searchBy.vid.options[document.searchBy.vid.selectedIndex].value);
//	payments.vid.options[document.payments.vid.selectedIndex].value
	/* Define a function to call once a response has been received. This will be our
		handleProductCategories function that we define below. */
	http.onreadystatechange = handleProducts; 
	/* Send the data. We use something other than null when we are sending using the POST
		method. */
	http.send(null);
}

/* Function called to handle the list that was returned from the internal_request.php file.. */
function handleProducts(){
	/* Make sure that the transaction has finished. The XMLHttpRequest object 
		has a property called readyState with several states:
		0: Uninitialized
		1: Loading
		2: Loaded
		3: Interactive
		4: Finished */
	if(http.readyState == 4){ //Finished loading the response
		/* We have got the response from the server-side script,
			let's see just what it was. using the responseText property of 
			the XMLHttpRequest object. */
		var response = http.responseText;
		/* And now we want to change the product_categories <div> content.
			we do this using an ability to get/change the content of a page element 
			that we can find: innerHTML. */
		document.getElementById('product_cage').innerHTML = response;
	}
}
