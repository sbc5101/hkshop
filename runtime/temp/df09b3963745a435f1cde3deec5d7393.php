<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:64:"D:\phpStudy\WWW\yoshop/application/api\view\order\add_order.html";i:1488422699;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="<?php echo url('api/order/make_order'); ?>" method="post">
		<div>
			<textarea name="data"></textarea>
		</div>
		<button type="submit">确认</button>
	</form>
</body>
</html>