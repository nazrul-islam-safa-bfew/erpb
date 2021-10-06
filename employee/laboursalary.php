<style>
table
{
border-collapse:collapse;
}
table, td, th
{
border:1px solid black;
}
</style>
 <?
//error_reporting(0);
include("../includes/config.inc.php");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
	?>
<form name="job" action="" method="post">
<table width="100%">
	   <tr bgcolor="#CC9999">
	   <td width="10%">Designation </td>
	     <td width="8%">Starting Basic </td>
		 <td width="7%"> Increment</td>
		 <td width="11%"> Basic with Increment </td>
	     <td width="7%">House Rent</td>
	     <td width="12%">Medical</td>
	     <td width="13%">Transportation</td>
	     <td width="9%">Profident Fund Adjustment</td>
	     <td width="13%">Income Tax Adjustment </td>
	     <td width="10%">Monthly Payable </td>
    </tr>
<tr bgcolor="#FFFF00">
	<td></td>
	<td>&nbsp;</td>
	<td><div align="right">106%</div></td>
	<td></td>
 <td><div align="right">60%</div></td>
	<td></td>
	<td></td>
	<td><div align="right">10%</div></td>
	<td></td>
	<td></td>
	</tr>
<tr>
  <td rowspan="15" valign="top" bgcolor="#66FFFF">High Skilled </td>
  <td rowspan="50" valign="top">3000</td>
  <td valign="top" align="right" bgcolor="#66FFFF">50</td>
  <td valign="top" align="right" bgcolor="#66FFFF">32,764</td>
  <td valign="top" align="right" bgcolor="#66FFFF">19,658</td>
  <td valign="top" bgcolor="#66FFFF"><div align="right">1,000</div></td>
  <td valign="top" bgcolor="#66FFFF"><div align="right">-</div></td>
  <td valign="top" align="right" bgcolor="#66FFFF">(3,276)</td>
  <td valign="top" bgcolor="#66FFFF">&nbsp;</td>
  <td valign="top" align="right" bgcolor="#66FFFF">50,146</td>
</tr>
<tr bgcolor="#66FFFF">
  <td align="right" valign="top">49</td>
  <td align="right" valign="top">31,204</td>
  <td align="right" valign="top">18,722 </td>
  <td valign="top"><div align="right">1,000</div></td>
  <td valign="top"><div align="right">-</div></td>
  <td align="right" valign="top">(3,120)</td>
  <td valign="top">&nbsp;</td>
  <td align="right" valign="top">47,806</td>
</tr>
<tr bgcolor="#66FFFF">
  <td align="right" valign="top">48</td>
  <td align="right" valign="top">29,718</td>
  <td align="right" valign="top">17,831 </td>
  <td valign="top"><div align="right">1,000</div></td>
  <td valign="top"><div align="right">-</div></td>
  <td align="right" valign="top">(2,972)</td>
  <td valign="top">&nbsp;</td>
  <td align="right" valign="top">45,577</td>
</tr>
<tr bgcolor="#66FFFF">
  <td align="right" valign="top">47</td>
  <td align="right" valign="top">28,303</td>
  <td align="right" valign="top">16,982 </td>
  <td valign="top"><div align="right">1,000</div></td>
  <td valign="top"><div align="right">-</div></td>
  <td align="right" valign="top">(2,830)</td>
  <td valign="top">&nbsp;</td>
  <td align="right" valign="top">43,454</td>
</tr>
<tr bgcolor="#66FFFF">
  <td align="right" valign="top">46</td>
  <td align="right" valign="top">26,955</td>
  <td align="right" valign="top">16,173 </td>
  <td valign="top"><div align="right">1,000</div></td>
  <td valign="top"><div align="right">-</div></td>
  <td align="right" valign="top">(2,696)</td>
  <td valign="top">&nbsp;</td>
  <td align="right" valign="top">41,433</td>
</tr>
<tr bgcolor="#66FFFF">
  <td align="right" valign="top">45</td>
  <td align="right" valign="top">25,671</td>
  <td align="right" valign="top">15,403 </td>
  <td valign="top"><div align="right">1,000</div></td>
  <td valign="top"><div align="right">-</div></td>
  <td align="right" valign="top">(2,567)</td>
  <td valign="top">&nbsp;</td>
  <td align="right" valign="top">39,507</td>
</tr>
<tr bgcolor="#66FFFF">
  <td align="right" valign="top">44</td>
  <td align="right" valign="top">24,449</td>
  <td align="right" valign="top">14,669 </td>
  <td valign="top"><div align="right">1,000</div></td>
  <td valign="top"><div align="right">-</div></td>
  <td align="right" valign="top">(2,445)</td>
  <td valign="top">&nbsp;</td>
  <td align="right" valign="top">37,674</td>
</tr>
<tr bgcolor="#66FFFF">
  <td align="right" valign="top">43</td>
  <td align="right" valign="top">23,285</td>
  <td align="right" valign="top">13,971 </td>
  <td valign="top"><div align="right">1,000</div></td>
  <td valign="top"><div align="right">-</div></td>
  <td align="right" valign="top">(2,328)</td>
  <td valign="top">&nbsp;</td>
  <td align="right" valign="top">35,927</td>
</tr>
<tr bgcolor="#66FFFF">
  <td align="right" valign="top">42</td>
  <td align="right" valign="top">22,176</td>
  <td align="right" valign="top">13,306 </td>
  <td valign="top"><div align="right">1,000</div></td>
  <td valign="top"><div align="right">-</div></td>
  <td align="right" valign="top">(2,218)</td>
  <td valign="top">&nbsp;</td>
  <td align="right" valign="top">34,264</td>
</tr>
<tr bgcolor="#FFCCFF">
  <td align="right" valign="top" bgcolor="#66FFFF">41</td>
  <td align="right" valign="top" bgcolor="#66FFFF">21,120</td>
  <td align="right" valign="top" bgcolor="#66FFFF">12,672 </td>
  <td valign="top" bgcolor="#66FFFF"><div align="right">1,000</div></td>
  <td valign="top" bgcolor="#66FFFF"><div align="right">-</div></td>
  <td align="right" valign="top" bgcolor="#66FFFF">(2,112)</td>
  <td valign="top" bgcolor="#66FFFF">&nbsp;</td>
  <td align="right" valign="top" bgcolor="#66FFFF">32,680</td>
</tr>
	<tr bgcolor="#66FFFF">
	  <td align="right" valign="top">40</td>
	  <td align="right" valign="top">20,114 </td>
	  <td align="right" valign="top">12,069 </td>
	  <td valign="top"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td align="right" valign="top">(2,011)</td>
	  <td valign="top">&nbsp;</td>
	  <td align="right" valign="top">31,171</td>
    </tr>
	<tr bgcolor="#66FFFF">
	<td align="right" valign="top">39</td>
	  <td align="right" valign="top">19,156</td>
	  <td align="right" valign="top">11,494 </td>
	  <td valign="top"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td align="right" valign="top">(1,916)</td>
	  <td valign="top">&nbsp;</td>
	  <td align="right" valign="top">29,735</td>
    </tr>
	<tr bgcolor="#66FFFF">
	<td align="right" valign="top">38</td>
	  <td align="right" valign="top">18,244</td>
	  <td align="right" valign="top">10,947 </td>
	  <td valign="top"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td align="right" valign="top">(1,824)</td>
	  <td valign="top">&nbsp;</td>
	  <td align="right" valign="top">28,366</td>
    </tr>
	<tr bgcolor="#66FFFF">
	<td align="right" valign="top">37</td>
	  <td align="right" valign="top">17,375</td>
	  <td align="right" valign="top">10,425 </td>
	  <td valign="top"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td align="right" valign="top">(1,738)</td>
	  <td valign="top">&nbsp;</td>
	  <td align="right" valign="top">27,063</td>
    </tr>
	<tr bgcolor="#66FFFF">
	<td align="right" valign="top">36</td>
	  <td align="right" valign="top">16,548</td>
	  <td align="right" valign="top">9,929 </td>
	  <td valign="top"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td align="right" valign="top">(1,655)</td>
	  <td valign="top">&nbsp;</td>
	  <td align="right" valign="top">25,822</td>
    </tr>
	<tr bgcolor="#FFCCFF">
	  <td rowspan="28" valign="top" bgcolor="#FFCCFF"> Skilled </td>

	<td valign="top" align="right">35</td>
	  <td valign="top" align="right">15,760</td>
	  <td valign="top" align="right">9,456 </td>
	  <td valign="top"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td valign="top" align="right">(1,576)</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top" align="right">24,640</td>
    </tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">34</td>
	  <td valign="top" align="right">15,010</td>
	  <td valign="top" align="right">9,006 </td>
	  <td valign="top"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td valign="top" align="right">(1,501)</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top" align="right">23,514</td>
    </tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">33</td>
	  <td valign="top" align="right">14,295</td>
	  <td valign="top" align="right">8,577 </td>
	  <td valign="top"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td valign="top" align="right">(1,429)</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top" align="right">22,442</td>
    </tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">32</td>
	  <td valign="top" align="right">13,614</td>
	  <td valign="top" align="right">8,168 </td>
	  <td valign="top"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td valign="top" align="right">(1,361)</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top" align="right">21,421</td>
    </tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">31</td>
	  <td valign="top" align="right">12,966</td>
	  <td valign="top" align="right">7,779 </td>
	  <td valign="top"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td valign="top" align="right">(1,297)</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top" align="right">20,449</td>
    </tr>
	<tr  bgcolor="#FFCCFF">
	<td valign="top" align="right">30</td>
	  <td valign="top" align="right">12,348</td>
	  <td valign="top" align="right">7,409 </td>
	  <td valign="top"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td valign="top" align="right">(1,235)</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top" align="right">19,523</td>
    </tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">29</td>
	  <td valign="top" align="right">11,760</td>
	  <td valign="top" align="right">7,056 </td>
	  <td valign="top"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td valign="top" align="right">(1,176)</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top" align="right">18,641</td>
    </tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">28</td>
	  <td valign="top" align="right">11,200</td>
	  <td valign="top" align="right">6,720 </td>
	  <td valign="top"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td valign="top" align="right">(1,120)</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top" align="right">17,801</td>
    </tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">27</td>
	  <td valign="top" align="right">10,667</td>
	  <td valign="top" align="right">6,400 </td>
	  <td valign="top" align="right"><div align="right">1,000</div></td>
	  <td><div align="right">-</div></td>
	  <td valign="top" align="right">(1,067)</td>
	  <td>&nbsp;</td>
	  <td valign="top" align="right">17,001</td>
    </tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">26</td>
	  <td valign="top" align="right">10,159</td>
	  <td valign="top" align="right">6,095 </td>
	  <td valign="top" align="right"><div align="right">1,000</div></td>
	  <td><div align="right">-</div></td>
	  <td valign="top" align="right">(1,016)</td>
	  <td>&nbsp;</td>
	  <td valign="top" align="right">16,239</td>
    </tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">25</td>
	  <td valign="top" align="right">9,675</td>
	  <td valign="top" align="right">5,805 </td>
	  <td valign="top" align="right"><div align="right">1,000</div></td>
	  <td><div align="right">-</div></td>
	  <td valign="top" align="right">(968)</td>
	  <td>&nbsp;</td>
	  <td valign="top" align="right">15,513</td>
    </tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">24</td>
	  <td valign="top" align="right">9,215</td>
	  <td valign="top" align="right">5,529 </td>
	  <td valign="top" align="right"><div align="right">1,000</div></td>
	  <td><div align="right">-</div></td>
	  <td valign="top" align="right">(921)</td>
	  <td>&nbsp;</td>
	  <td valign="top" align="right">14,822</td>
    </tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">23</td>
	  <td valign="top" align="right">8,776</td>
	  <td valign="top" align="right">5,265 </td>
	  <td valign="top" align="right"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td valign="top" align="right">(878)</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top" align="right">14,164</td>
    </tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">22</td>
	  <td valign="top" align="right">8,358</td>
	  <td valign="top" align="right">5,015 </td>
	  <td valign="top" align="right"><div align="right">1,000</div></td>
	  <td valign="top"><div align="right">-</div></td>
	  <td valign="top" align="right">(836)</td>
	  <td valign="top">&nbsp;</td>
	  <td valign="top" align="right">13,537</td>
    </tr>
	<tr>
	  <td valign="top" align="right" bgcolor="#FFCCFF">21</td>
	  <td valign="top" align="right" bgcolor="#FFCCFF">7,960</td>
	  <td valign="top" align="right" bgcolor="#FFCCFF">4,776 </td>
	  <td valign="top" align="right" bgcolor="#FFCCFF"><div align="right">750</div></td>
	  <td valign="top" bgcolor="#FFCCFF"><div align="right">-</div></td>
	  <td valign="top" align="right" bgcolor="#FFCCFF">(796)</td>
	  <td valign="top" bgcolor="#FFCCFF">&nbsp;</td>
	  <td valign="top" align="right" bgcolor="#FFCCFF">12,690</td>
    </tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">20</td>
	<td valign="top" align="right">7,581</td>
    <td valign="top" align="right">4,549 </td>
    <td valign="top" align="right"><div align="right">750</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(758)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">12,121</td>
	</tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">19</td>
	<td valign="top" align="right">7,220</td>
    <td valign="top" align="right">4,332 </td>
	<td valign="top" align="right"><div align="right">750</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(722)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">11,580</td>
	</tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">18</td>
	<td valign="top" align="right">6,876</td>
    <td valign="top" align="right">4,126 </td>
	<td valign="top" align="right"><div align="right">750</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(688)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">11,064</td>
	</tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">17</td>
	<td valign="top" align="right">6,549</td>
    <td valign="top" align="right">3,929 </td>
	<td valign="top" align="right"><div align="right">750</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(655)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">10,573</td>
	</tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">16</td>
	<td valign="top" align="right">6,237</td>
    <td valign="top" align="right">3,742 </td>
	<td valign="top" align="right"><div align="right">750</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(624)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">10,105</td>
	</tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">15</td>
	<td valign="top" align="right">5,940</td>
    <td valign="top" align="right">3,564 </td>
	<td valign="top" align="right"><div align="right">750</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(594)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">9,660</td>
	</tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">14</td>
	<td valign="top" align="right">5,657</td>
    <td valign="top" align="right">3,394 </td>
	<td valign="top" align="right"><div align="right">750</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(566)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">9,235</td>
	</tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">13</td>
	<td valign="top" align="right">5,388</td>
    <td valign="top" align="right">3,233 </td>
	<td valign="top" align="right"><div align="right">750</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(539)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">8,831</td>
	</tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">12</td>
	<td valign="top" align="right">5,131</td>
    <td valign="top" align="right">3,079 </td>
	<td valign="top" align="right"><div align="right">750</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(513)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">8,447 </td>
	</tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">11</td>
	<td valign="top" align="right">4,887</td>
    <td valign="top" align="right">2,932 </td>
	<td valign="top" align="right"><div align="right">750</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(489)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">8,080</td>
	</tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">10</td>
	<td valign="top" align="right">4,654</td>
    <td valign="top" align="right">2,792 </td>
	<td valign="top" align="right"><div align="right">500</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(465)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">7,481 </td>
	</tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">9</td>
	<td valign="top" align="right">4,432</td>
    <td valign="top" align="right">2,659 </td>
	<td valign="top" align="right"><div align="right">500</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(443)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">7,149 </td>
	</tr>
	<tr bgcolor="#FFCCFF">
	<td valign="top" align="right">8</td>
	<td valign="top" align="right">4,221</td>
    <td valign="top" align="right">2,533 </td>
	<td valign="top" align="right"><div align="right">500</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(422)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">6,832 </td>
	</tr>
	<tr>
		<td rowspan="7" valign="top">Semi Skilled </td>

	<td valign="top" align="right">7</td>
	<td valign="top" align="right">4,020</td>
    <td valign="top" align="right">2,412 </td>
	<td valign="top" align="right"><div align="right">500</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(402)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">6,530 </td>
	</tr>
	<tr>
	<td valign="top" align="right">6</td>
	<td valign="top" align="right">3,829</td>
    <td valign="top" align="right">2,297 </td>
    <td valign="top" align="right"><div align="right">500</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(383)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">6,243 </td>
	</tr>
	<tr>
	<td valign="top" align="right">5</td>
	<td valign="top" align="right">3,647</td>
    <td valign="top" align="right">2,188 </td>
	<td valign="top" align="right"><div align="right">500</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(365)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">5,970 </td>
	</tr>
	<tr>
	<td valign="top" align="right">4</td>
	<td valign="top" align="right">3,473</td>
    <td valign="top" align="right">2,084 </td>
	<td valign="top" align="right"><div align="right">500</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(347)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">5,709 </td>
	</tr>
	<tr>
	<td valign="top" align="right">3</td>
	<td valign="top" align="right">3,308</td>
    <td valign="top" align="right">1,985 </td>
	<td valign="top" align="right"><div align="right">500</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(331)</td>
	<td valign="top" >&nbsp;</td>
	<td valign="top" align="right">5,461 </td>
	</tr>
	<tr>
	<td valign="top" align="right">2</td>
	<td valign="top" align="right">3,150 </td>
    <td valign="top" align="right">1,890 </td>
	<td valign="top" align="right"><div align="right">500</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(315)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">5,225 </td>
	</tr>
	<tr>
	<td valign="top" align="right">1</td>
	<td valign="top" align="right">3,000 </td>
    <td valign="top" align="right">1,800 </td>
	<td valign="top" align="right"><div align="right">500</div></td>
	<td valign="top" align="right"><div align="right">-</div></td>
	<td valign="top" align="right">(300)</td>
	<td valign="top">&nbsp;</td>
	<td valign="top" align="right">5,000</td>
	</tr>
  </table>
</form>
<a target="_blank" href="./print/print_createJob.php?designation=<? echo $designation;?>">Print</a>