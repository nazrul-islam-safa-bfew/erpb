
function checkrequired1(which) {
//alert(which.name); 
var pass=true;

for (i=0;i<which.length;i++) {
var tempobj=which.elements[i];
if (tempobj.alt=="req") {
if (((tempobj.type=="text"||tempobj.type=="textarea")&& tempobj.value=='')||(tempobj.type.toString().charAt(0)=="s"&& tempobj.selectedIndex==0)) {
pass=false;
break;
         }
      }
   }

if (!pass) {
shortFieldName=tempobj.title;
alert("Please make sure the "+shortFieldName+" field was properly completed.");
return false;
}
else
return true;
}
