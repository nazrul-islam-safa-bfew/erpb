 function twoDigitConversation(who,theName){ //function by suvro 
	theOldValue=document.getElementById(theName).value;
	theNewValue=parseFloat(theOldValue).toFixed(2);
	document.getElementById(theName).value=theNewValue;
	
 }
 function ShowDiv(divName){   
 var divmain = document.getElementById(divName);        		 
   divmain.className= "visible";			   
   }
 function hidDiv(divName){           		 
 var divmain = document.getElementById(divName);        		 
   divmain.className= "hidden";
   }

 function ShowHead(divName){   
 var divmain = document.getElementById(divName);        		 
 if(divmain.className=="visible")divmain.className= "hidden";
	else divmain.className="visible";
   }
 function HideHead(divName){   
 var divmain = document.getElementById(divName);        		 
	divmain.className= "hidden";
   }			   

/* For Add two field*/
function addMe(form, f11, f12){
 var totalPrice = parseFloat(f11) + parseFloat(f12);
 return totalPrice;
}

function divMe(f11, f12){
 var totalPrice = parseFloat(f11) / parseFloat(f12);
 return Math.round(totalPrice*100)/100;
}



/* For Sub two field*/
function subMe(form, f11, f12){
 var totalPrice = parseFloat(f11) - parseFloat(f12);
 return totalPrice;
}

/*for multiple 2 filed*/
function multipleMe(form, f11, f12,f13,f14,f15,f16,re){

  f1=parseFloat(f11.value);
  f2=parseFloat(f12.value);
  f3=parseFloat(f13.value);  
  f4=parseFloat(f14.value);  
 var totalPrice=0;  


if(!f1 && !f2 && !f3 && !f4)
  {
   f1=f2=f3=f4=0;
   f16.value=0; 
    }
  else {
	 if(!f1) f1=1;
	 if(!f2) f2=1;
	 if(!f3) f3=1;
	 if(!f4) f4=1; 

 totalPrice =f2*f3*f4;  
 f15.value=totalPrice;
 var totalQty=f1*totalPrice; 
		console.log(totalPrice);
 if(f1 && totalQty<=re.value) f16.value=totalQty; 
  else {alert('Check you values. Your values may be excedding receivable Values!!'); f16.value=0; }
 }
 return totalPrice;
}


/*for multiple 3 filed*/
function multipleMe3(form, f11, f12, f13){
  
  f1=parseFloat(f11);
  f2=parseFloat(f12);
  f3=parseFloat(f13);
  
 if(!f1) f1=1;
 if(!f2) f2=1;
 if(!f3) f3=1;


  var totalPrice =f1*f2*f3;

 return totalPrice;
}

function ad(input,input2,output1,output2) {

var total = parseInt(input.value)-parseInt(input2.value);
//alert(total);
if(total==0) {output1.value=0;
  output2.value=0;
  //alert(total);
  }

else if(total>0)
output2.value=total;
else if(total<0) output1.value=total*(-1);
}


<!-- Begin
var isNN = (navigator.appName.indexOf("Netscape")!=-1);
function autoTab(input,len, e) {

var keyCode = (isNN) ? e.which : e.keyCode; 
var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
if(input.value.length >= len && !containsElement(filter,keyCode)) {
input.value = input.value.slice(0, len);
input.form[(getIndex(input)+1) % input.form.length].focus();
}
function containsElement(arr, ele) {
var found = false, index = 0;
while(!found && index < arr.length)
if(arr[index] == ele)
found = true;
else
index++;
return found;
}
function getIndex(input) {
var index = -1, i = 0, found = false;
while (i < input.form.length && index == -1)
if (input.form[i] == input)index = i;
else i++;
return index;
}
return true;
}
//  End -->

<!--Begin 
//if(document.ven.cfacility[2].checked) {alert('ss');document.ven.camount.disabled='true';document.ven.camount.className='disabled'}"
function credit(){
	if(document.ven.cfacility[0].checked || document.ven.cfacility[1].checked) 
	{
	document.ven.camount.disabled=true;
	document.ven.camount.className='disabled'
	document.ven.camount.value=''	
	document.ven.cduration.disabled=true;
	document.ven.cduration.className='disabled';
	document.ven.cduration.value='';	
	} 
	else 
	{
	document.ven.camount.disabled=false;
	document.ven.camount.className=''
	document.ven.cduration.disabled=false;
	document.ven.cduration.className='';
	} 

}
function credit0(){
	if(document.ven.advance[0].checked) 
	{
	document.ven.advanceText.disabled=true;
	document.ven.advanceText.className='disabled'
	document.ven.advanceText.value=''	
	} 
	else 
	{
	document.ven.advanceText.disabled=false;
	document.ven.advanceText.className=''
	} 

}


function credit01(t){

	
}


//  End -->

function selector1(form, v)
{
	if(v==0){
	   form.qualityText.disabled=true;
	   form.qualityText.className='disabled';
	   form.qualityText.value='';	   
      }
	else{
	   form.qualityText.disabled=false;
	   form.qualityText.className='';
      }
}
function selector2(form, v)
{
	if(v==0){
	   form.reliabilityText.disabled=true;
	   form.reliabilityText.className='disabled';
	   form.reliabilityText.value='';	   
      }
	else{
	   form.reliabilityText.disabled=false;
	   form.reliabilityText.className='';
      }
}

function selector3(form, v)
{
	if(v==0){
	   form.availabilityText.disabled=true;
	   form.availabilityText.className='disabled';
	   form.availabilityText.value='';	   
      }
	else{
	   form.availabilityText.disabled=false;
	   form.availabilityText.className='';
      }
}
function selector4(form, v)
{
	if(v==0){
	   form.experienceMText.disabled=true;
	   form.experienceMText.className='disabled';
	   form.experienceMText.value='';	   
      }
	else{
	   form.experienceMText.disabled=false;
	   form.experienceMText.className='';
      }
}






function selector4Cul(form, v)
{
mngCultureTxt=document.getElementById("mngCultureTxt");

	if(v==0){
	   mngCultureTxt.disabled=true;
	   mngCultureTxt.className='disabled';
	   mngCultureTxt.value='';
	   
      }
	else{
	   mngCultureTxt.disabled=false;
	   mngCultureTxt.className='';
		
      }
}




function selector4Beha(form, v)
{
orgBehaviorTxt=document.getElementById("orgBehaviorTxt");
	if(v==0){
	   orgBehaviorTxt.disabled=true;
	   orgBehaviorTxt.className='disabled';
	   orgBehaviorTxt.value='';	   
      }
	else{
	   orgBehaviorTxt.disabled=false;
	   orgBehaviorTxt.className='';
      }
}


function selector4Type(form, v)
{
VendorTypeTxt=document.getElementById("VendorTypeTxt");

	if(v==0){
	   VendorTypeTxt.disabled=true;
	   VendorTypeTxt.className='disabled';
	   VendorTypeTxt.value='';	   
      }
	else{
	   VendorTypeTxt.disabled=false;
	   VendorTypeTxt.className='';
      }
}









function selector5(form, v)
{
	if(v==0){
	   form.experienceBText.disabled=true;
	   form.experienceBText.className='disabled';
	   form.experienceBText.value='';	   
      }
	else{
	   form.experienceBText.disabled=false;
	   form.experienceBText.className='';
      }
}
function selector6(form, v)
{
	if(v==0){
	   form.serviceText.disabled=true;
	   form.serviceText.className='disabled';
	   form.serviceText.value='';	   
      }
	else{
	   form.serviceText.disabled=false;
	   form.serviceText.className='';
      }
}

function ShowExtraQuestImage(divName)
{    
	var divmain = document.getElementById(divName);

	if (divmain.className == "hidden")
	{	
	    for (i = 1; i <= 4; i++)
		 { var d="div"+i;
	           var divtemp = document.getElementById(d);		 
		   divtemp.className= "hidden";
		  }

	    divmain.className = "visible";		
	}
}
function nextField(input, e) {

var keyCode =  e.keyCode;
//alert(keyCode);

if(keyCode==13)
input.form[(getIndex(input)+1)].focus();

function getIndex(input) {
var index = -1, i = 0, found = false;
while (i < input.form.length && index == -1)
if (input.form[i] == input)index = i;
else i++;
return index;
}
return true;
}

function calc(which,cal="cal"){
	var total=0;
	which.total.value=0;
	//alert(which);
	for (i=0;i<which.length;i++){
		var tempobj=which.elements[i];
		//alert(tempobj.alt);
		if(tempobj.alt==cal){
			console.log(tempobj);
			if(tempobj.value)
				total+=parseFloat(tempobj.value);
		}
	}
	which.total.value=total.toFixed(2);
	which.save.disabled=false;
	//alert(total);
}

function disableSave(which){
which.save.disabled=true;
}
