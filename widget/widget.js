document.write("<table><tr><td style=\"text-align:center\">");
document.write("<img src=\"https:\/\/shuttleone.network\/gets_v2\/assets\/imgs\/logo\/gets.png\">");
document.write("<\/td><\/tr>");
document.write("");
document.write("<tr><td style=\"text-align:center\">");
document.write("<button class=\"myButton\" onclick=\"callPopup()\">Click to try<\/button>");
document.write("<\/td><\/tr>");
document.write("<\/table>");
document.write("<style>");
document.write(".myButton {");
document.write("	background-color:#44c767;");
document.write("	border-radius:28px;");
document.write("	border:1px solid #18ab29;");
document.write("	display:inline-block;");
document.write("	cursor:pointer;");
document.write("	color:#ffffff;");
document.write("	font-family:Arial;");
document.write("	font-size:17px;");
document.write("	padding:5px 31px;");
document.write("	text-decoration:none;");
document.write("	text-shadow:0px 1px 0px #2f6627;");
document.write("}");
document.write(".myButton:hover {");
document.write("	background-color:#5cbf2a;");
document.write("}");
document.write(".myButton:active {");
document.write("	position:relative;");
document.write("	background-color:#5cbf2a;");
document.write("	top:1px;");
document.write("}");
document.write("<\/style>");



function callPopup() {
	var win = window.open("http://shuttleone.network/gets_v2/widget/widget_loan_new.php","","width=600,height=520,toolbar=no,menubar=no,resizable=yes");
	// var win = window.open("http://localhost:8888/gets_v2/widget/widget_loan_new.php","","width=600,height=520,toolbar=no,menubar=no,resizable=yes");
}