<!DOCTYPE html>
<html style="height: 100%;">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title> Dots Document Server</title>
</head>
<body style="height: 100%; margin: 0;">
    <div id="docplaceholder" style="height: 100%"></div>
    <script type="text/javascript" src="https://snappy.sizaf.com/web-apps/apps/api/documents/api.js"></script>

    <script type="text/javascript">
    
        var docEditor;

        var options = <?php echo json_encode($options); ?>;

       
        docEditor = new DocsAPI.DocEditor("docplaceholder", options);

    </script>
</body>
</html>