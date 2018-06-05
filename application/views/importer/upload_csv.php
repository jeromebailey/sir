<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form method="post" action="<?=base_url('Importer/do_import_stock_file');?>" enctype="multipart/form-data">
	<input type="file" name="csv_file" /> <input type="submit" name="">
</form>
</body>
</html>