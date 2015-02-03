<!DOCTYPE html>
<html lang="$ContentLocale">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <% base_tag %>
    <title>$ApplicationName | $SectionTitle</title>
</head>
<body class="cms">
    <div class="right">
        $FlashMessage
        <% if $PageSubTitle %><h2 id="subtitle">$PageSubTitle</h2><% end_if %>
        <% if $Feedback %>$Feedback<% end_if %>
        $Form
        <script type="text/javascript">
            jQuery('.newsletter-loader', parent.document).hide();
        </script>
    </div>
</body>
</html>