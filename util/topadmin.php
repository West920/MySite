
<html>
<head>
<title><?php echo $titlepage; ?></title>
<?
    if (!isset($style)) {
    ?>
        <link rel="StyleSheet" type="text/css" href="<? echo $style ?>">    
    <?
    }
?>
<link rel="StyleSheet" type="text/css" href="../util/admin.css">
<link rel="StyleSheet" type="text/css" href="util/admin.css">
<body leftmargin="0" marginheight="0" marginwidth="0" rightmargin="0" bottommargin="0" topmargin="0" >

<table border="0" cellpadding="0" cellspacing="20" >
    <tr valign="top">
        <td><nobr><h1 class=z1><? echo nl2br($titlepage); ?></h1></nobr></td>
    </tr>

</table>
<table width=100%><tr><td width=10%>&nbsp;</td><td>