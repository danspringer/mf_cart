# Cart

Cart ist eine einfache PHP-Klasse, die einen Warenkorb ohne Checkout zur Verfügung stellt. Warenkorb-Items können in PHP-Sessions oder Browser-Cookie gespeichert werden. Cart eignet sich z.B. auch zur Erstellung einer Merkliste oder eines Wunschzettels.



## Nutzung

### Konfiguration

Konfiguration ist möglich über die AddOn-Einstellungen oder man initialisiert den Warenkorb manuell.

##### Einbindung des WK bei Konfiguration über das AddOn:
```
$cartMaxItem = rex_addon::get('mf_cart')->getConfig('cartMaxItem');
$itemMaxQuantity = rex_addon::get('mf_cart')->getConfig('itemMaxQuantity');
$useCookie = (rex_addon::get('mf_cart')->getConfig('useCookie') == 'true' ? true : false);

$cart = new Cart([
	'cartMaxItem' => $cartMaxItem,
	'itemMaxQuantity' => $itemMaxQuantity,
	'useCookie' => $useCookie,
]);
```

##### Einbindung des WK bei manueller Konfiguration:
```
$cart = new Cart([
	'cartMaxItem' => 0,
	'itemMaxQuantity' => 0,
	'useCookie' => false,
]);
```
 

##### Optionen

| Parameter       | Type     | Description                                                  |
| --------------- | -------- | ------------------------------------------------------------ |
| cartMaxItem     | **int**  | Die maximale Anzahl an Items, die im Warenkorb liegen können. 0 = Unbegrenzt         |
| itemMaxQuantity | **int**  | Maximale Anzahl eines Items, das in den Warenkorb gelegt werden kann. 0 = Unbegrenzt |
| useCookie       | **bool** | Ohne Cookie wird der WK nur in der Session gespeichert. Wenn der Browser geschlossen wird, wird der WK geleert. Mit gesetztem Cookie bleibt der Warenkorb bei folgenden Besuchen innerhalb der nächsten 7 Tage bestehen.         |

## Beispielhafte Nutzung in einem Template

```php
// A collection of sample products
$products = json_decode('[{"id":100,"name":"iPhone SE (32 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30917969-cc1b8586-a3cf-11e7-872c-92d98d24afb0.png","width":200,"height":250},"colors":{"silver":"Silver","gold":"Gold","space-gray":"Space Gray","rose-gold":"Rose Gold"},"price":"349.00"},{"id":101,"name":"iPhone SE (128 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30917969-cc1b8586-a3cf-11e7-872c-92d98d24afb0.png","width":200,"height":250},"colors":{"silver":"Silver","gold":"Gold","space-gray":"Space Gray","rose-gold":"Rose Gold"},"price":"449.00"},{"id":102,"name":"iPhone 6s (32 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30917728-4052e8c8-a3cf-11e7-93df-7ac32ab8dca5.png","width":157,"height":250},"colors":{"silver":"Silver","gold":"Gold","space-gray":"Space Gray","rose-gold":"Rose Gold"},"price":"449.00"},{"id":103,"name":"iPhone 6s (128 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30917728-4052e8c8-a3cf-11e7-93df-7ac32ab8dca5.png","width":157,"height":250},"colors":{"silver":"Silver","gold":"Gold","space-gray":"Space Gray","rose-gold":"Rose Gold"},"price":"549.00"},{"id":104,"name":"iPhone 6s Plus (32 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30917727-405206e2-a3cf-11e7-943c-b9bc44155c24.png","width":158,"height":250},"colors":{"silver":"Silver","gold":"Gold","space-gray":"Space Gray","rose-gold":"Rose Gold"},"price":"549.00"},{"id":105,"name":"iPhone 6s Plus (128 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30917727-405206e2-a3cf-11e7-943c-b9bc44155c24.png","width":158,"height":250},"colors":{"silver":"Silver","gold":"Gold","space-gray":"Space Gray","rose-gold":"Rose Gold"},"price":"649.00"},{"id":106,"name":"iPhone 7 (32 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30917729-405340fc-a3cf-11e7-8553-3128f2668c22.png","width":182,"height":250},"colors":{"jet-black":"Jet Black","black":"Black","silver":"Silver","gold":"Gold","rose-gold":"Rose Gold"},"price":"549.00"},{"id":107,"name":"iPhone 7 (128 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30917729-405340fc-a3cf-11e7-8553-3128f2668c22.png","width":182,"height":250},"colors":{"jet-black":"Jet Black","black":"Black","silver":"Silver","gold":"Gold","rose-gold":"Rose Gold"},"price":"649.00"},{"id":108,"name":"iPhone 7 Plus (32 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30917731-407d0fa4-a3cf-11e7-9454-013bf60565e2.png","width":178,"height":250},"colors":{"jet-black":"Jet Black","black":"Black","silver":"Silver","gold":"Gold","rose-gold":"Rose Gold"},"price":"669.00"},{"id":109,"name":"iPhone 7 Plus (128 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30917731-407d0fa4-a3cf-11e7-9454-013bf60565e2.png","width":178,"height":250},"colors":{"jet-black":"Jet Black","black":"Black","silver":"Silver","gold":"Gold","rose-gold":"Rose Gold"},"price":"769.00"},{"id":110,"name":"iPhone 8 (64 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30917730-405386fc-a3cf-11e7-96fd-94a171614c39.png","width":182,"height":250},"colors":{"silver":"Silver","gold":"Gold","space-gray":"Space Gray"},"price":"699.00"},{"id":111,"name":"iPhone 8 (256 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30917730-405386fc-a3cf-11e7-96fd-94a171614c39.png","width":182,"height":250},"colors":{"silver":"Silver","gold":"Gold","space-gray":"Space Gray"},"price":"799.00"},{"id":112,"name":"iPhone 8 Plus (64 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30917726-404df20a-a3cf-11e7-87e2-dd4888daa658.png","width":177,"height":250},"colors":{"silver":"Silver","gold":"Gold","space-gray":"Space Gray"},"price":"799.00"},{"id":113,"name":"iPhone 8 Plus (256 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30917726-404df20a-a3cf-11e7-87e2-dd4888daa658.png","width":177,"height":250},"colors":{"silver":"Silver","gold":"Gold","space-gray":"Space Gray"},"price":"949.00"},{"id":114,"name":"Apple TV 4K (32 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30942290-a9c91b5e-a41c-11e7-99f8-18d91be86d94.png","width":252,"height":250},"colors":[],"price":"179.00"},{"id":115,"name":"Apple TV 4K (64 GB)","image":{"source":"https:\/\/user-images.githubusercontent.com\/73107\/30942290-a9c91b5e-a41c-11e7-99f8-18d91be86d94.png","width":252,"height":250},"colors":[],"price":"199.00"}]');

$colors = [
	'black'      => 'Black',
	'space-gray' => 'Space Gray',
	'jet-black'  => 'Jet Black',
	'silver'     => 'Silver',
	'gold'       => 'Gold',
	'rose-gold'  => 'Rose Gold',
];

// Page
$a = (isset($_GET['a'])) ? $_GET['a'] : 'home';

#require_once 'class.Cart.php';

// Initialize cart object
$cartMaxItem = rex_addon::get('mf_cart')->getConfig('cartMaxItem');
$itemMaxQuantity = rex_addon::get('mf_cart')->getConfig('itemMaxQuantity');
$useCookie = (rex_addon::get('mf_cart')->getConfig('useCookie') == 'true' ? true : false);



$cart = new Cart([
	// Maximum item can added to cart, 0 = Unlimited
	'cartMaxItem' => $cartMaxItem,
	
	// Maximum quantity of a item can be added to cart, 0 = Unlimited
	'itemMaxQuantity' => $itemMaxQuantity,

	// Do not use cookie, cart items will gone after browser closed
	'useCookie' => $useCookie,
]);

// Shopping Cart Page
if ($a == 'cart') {
	$cartContents = '
	<div class="alert alert-warning">
		<i class="fa fa-info-circle"></i> There are no items in the cart.
	</div>';

	// Empty the cart
	if (isset($_POST['empty'])) {
		$cart->clear();
	}

	// Add item
	if (isset($_POST['add'])) {
		foreach ($products as $product) {
			if ($_POST['id'] == $product->id) {
				break;
			}
		}

		$cart->add($product->id, $_POST['qty'], [
			'price' => $product->price,
			'color' => (isset($_POST['color'])) ? $_POST['color'] : '',
		]);
	}

	// Update item
	if (isset($_POST['update'])) {
		foreach ($products as $product) {
			if ($_POST['id'] == $product->id) {
				break;
			}
		}

		$cart->update($product->id, $_POST['qty'], [
			'price' => $product->price,
			'color' => (isset($_POST['color'])) ? $_POST['color'] : '',
		]);
	}

	// Remove item
	if (isset($_POST['remove'])) {
		foreach ($products as $product) {
			if ($_POST['id'] == $product->id) {
				break;
			}
		}

		$cart->remove($product->id, [
			'price' => $product->price,
			'color' => (isset($_POST['color'])) ? $_POST['color'] : '',
		]);
	}

	if (!$cart->isEmpty()) {
		$allItems = $cart->getItems();

		$cartContents = '
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th class="col-md-7">Product</th>
					<th class="col-md-3 text-center">Quantity</th>
					<th class="col-md-2 text-right">Price</th>
				</tr>
			</thead>
			<tbody>';

		foreach ($allItems as $id => $items) {
			foreach ($items as $item) {
				foreach ($products as $product) {
					if ($id == $product->id) {
						break;
					}
				}

				$cartContents .= '
				<tr>
					<td>' . $product->name . ((isset($item['attributes']['color'])) ? ('<p><strong>Color: </strong>' . $colors[$item['attributes']['color']] . '</p>') : '') . '</td>
					<td class="text-center"><div class="form-group"><input type="number" value="' . $item['quantity'] . '" class="form-control quantity pull-left" style="width:100px"><div class="pull-right"><button class="btn btn-default btn-update" data-id="' . $id . '" data-color="' . ((isset($item['attributes']['color'])) ? $item['attributes']['color'] : '') . '"><i class="fa fa-refresh"></i> Update</button><button class="btn btn-danger btn-remove" data-id="' . $id . '" data-color="' . ((isset($item['attributes']['color'])) ? $item['attributes']['color'] : '') . '"><i class="fa fa-trash"></i></button></div></div></td>
					<td class="text-right">$' . $item['attributes']['price'] . '</td>
				</tr>';
			}
		}

		$cartContents .= '
			</tbody>
		</table>

		<div class="text-right">
			<h3>Total:<br />$' . number_format($cart->getAttributeTotal('price'), 2, '.', ',') . '</h3>
		</div>

		<p>
			<div class="pull-left">
				<button class="btn btn-danger btn-empty-cart">Empty Cart</button>
			</div>
			<div class="pull-right text-right">
				<a href="?a=home" class="btn btn-default">Continue Shopping</a>
				<a href="?a=checkout" class="btn btn-danger">Checkout</a>
			</div>
		</p>';
	}
}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Cart - A Simple PHP Cart Library by Sei Kan</title>

		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/cosmo/bootstrap.min.css" rel="stylesheet">
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

		<style>
			body{margin-top:50px;margin-bottom:200px}
		</style>
	</head>

	<body>
		<div class="navbar navbar-default navbar-fixed-top">
			<div class="container">
				<div class="navbar-header">
					<a href="?a=shop" class="navbar-brand">Sample Shop</a>
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="navbar-collapse collapse" id="navbar-main">
					<ul class="nav navbar-nav">
						<li><a href="?a=cart" id="li-cart"><i class="fa fa-shopping-cart"></i> Cart (<?php echo $cart->getTotalItem(); ?>)</a></li>
					</ul>
				</div>
			</div>
		</div>

		<?php if ($a == 'cart'): ?>
		<div class="container">
			<h1>Shopping Cart</h1>

			<div class="row">
				<div class="col-md-12">
					 <div class="table-responsive">
						<?php echo $cartContents; ?>
					 </div>
				</div>
			</div>
		</div>
		<?php elseif ($a == 'checkout'): ?>
		<div class="container">
			<h1>Checkout</h1>

			<div class="row">
				<div class="col-md-12">
					 <div class="table-responsive">
					 	<?php dump($cart->getItems()); ?>
					 </div>
				</div>
			</div>
		</div>
		<?php else: ?>
		<div class="container">
			<h1>Products</h1>
			<div class="row">
				<?php
				foreach ($products as $product) {
					dump($product);
					echo '
					<div class="col-md-6">
						<h3>' . $product->name . '</h3>

						<div>
							<div class="pull-left">
								<img src="' . $product->image->source . '" border="0" width="' . $product->image->width . '" height="' . $product->image->height . '" title="' . $product->name . '" />
							</div>
							<div class="pull-right">
								<h4>$' . $product->price . '</h4>
								<form>
									<input type="hidden" value="' . $product->id . '" class="product-id" />';

					if ($product->colors) {
						echo '
										<div class="form-group">
											<label>Color:</label>
											<select class="form-control color">';

						foreach ($product->colors as $key => $value) {
							echo '
												<option value="' . $key . '"> ' . $value . '</option>';
						}

						echo '
											</select>
										</div>';
					}

					echo '

									<div class="form-group">
										<label>Quantity:</label>
										<input type="number" value="1" class="form-control quantity" />
									</div>
									<div class="form-group">
										<button class="btn btn-danger add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
									</div>
								</form>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>';
				}
				?>
			</div>
		</div>
		<?php endif; ?>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

		<script>
			$(document).ready(function(){
				$('.add-to-cart').on('click', function(e){
					e.preventDefault();

					var $btn = $(this);
					var id = $btn.parent().parent().find('.product-id').val();
					var color = $btn.parent().parent().find('.color').val() || '';
					var qty = $btn.parent().parent().find('.quantity').val();

					var $form = $('<form action="?a=cart" method="post" />').html('<input type="hidden" name="add" value=""><input type="hidden" name="id" value="' + id + '"><input type="hidden" name="color" value="' + color + '"><input type="hidden" name="qty" value="' + qty + '">');

					$('body').append($form);
					$form.submit();
				});

				$('.btn-update').on('click', function(){
					var $btn = $(this);
					var id = $btn.attr('data-id');
					var qty = $btn.parent().parent().find('.quantity').val();
					var color = $btn.attr('data-color');

					var $form = $('<form action="?a=cart" method="post" />').html('<input type="hidden" name="update" value=""><input type="hidden" name="id" value="'+id+'"><input type="hidden" name="qty" value="'+qty+'"><input type="hidden" name="color" value="'+color+'">');

					$('body').append($form);
					$form.submit();
				});

				$('.btn-remove').on('click', function(){
					var $btn = $(this);
					var id = $btn.attr('data-id');
					var color = $btn.attr('data-color');

					var $form = $('<form action="?a=cart" method="post" />').html('<input type="hidden" name="remove" value=""><input type="hidden" name="id" value="'+id+'"><input type="hidden" name="color" value="'+color+'">');

					$('body').append($form);
					$form.submit();
				});

				$('.btn-empty-cart').on('click', function(){
					var $form = $('<form action="?a=cart" method="post" />').html('<input type="hidden" name="empty" value="">');

					$('body').append($form);
					$form.submit();
				});
			});
		</script>
	</body>
</html>

```

## Benutzung

### Add Item

Adds an item to cart. 

> **bool** \$cart->add( **string** \$id\[, **int** \$quantity\]\[, **array** $attributes\] );

```php
// Add item with ID #1001
$cart->add('1001');

// Add 5 item with ID #1002
$cart->add('1002', 5);

// Add item with ID #1003 with price, color, and size
$cart->add('1003', 1, [
  'price'  => '5.99',
  'color'  => 'White',
  'size'   => 'XS',
]);

// Item with same ID but different attributes will added as separate item in cart
$cart->add('1003', 1, [
  'price'  => '5.99',
  'color'  => 'Red',
  'size'   => 'M',
]);
```



### Update Item

Updates quantity of an item. Attributes **must be** provides if item with same ID exists with different attributes.

> **bool** \$cart->update( **string** \$id, **int** $quantity\[, **array** \$attributes\] );

```php
// Set quantity for item #1001 to 5
$cart->update('1001', 5);

// Set quantity for item #1003 to 2
$cart->update('1003', 2, [
  'price'  => '5.99',
  'color'  => 'Red',
  'size'   => 'M',
]);
```



### Remove Item

Removes an item. Attributes **must be** provided to remove specified item, or all items with same ID will be removed from cart.

> **bool** \$cart->remove( **string** $id\[, **array** \$attributes\] );

```php
// Remove item #1001
$cart->remove('1001');

// Remove item #1003 with color White and size XS
$cart->remove('1003', [
  'price'  => '5.99',
  'color'  => 'White',
  'size'   => 'XS',
]);
```



### Get Items

Gets a multi-dimensional array of items stored in cart.

> **array** \$cart->getItems( );

```php
// Get all items in the cart
$allItems = $cart->getItems();

foreach ($allItems as $items) {
  foreach ($items as $item) {
    echo 'ID: '.$item['id'].'<br />';
    echo 'Qty: '.$item['quantity'].'<br />';
    echo 'Price: '.$item['attributes']['price'].'<br />';
    echo 'Size: '.$item['attributes']['size'].'<br />';
    echo 'Color: '.$item['attributes']['color'].'<br />';
  }
}
```



### Check Cart Empty

Checks if the cart is empty.

> **bool** \$cart->isEmpty( );

```php
if ($cart->isEmpty()) {
  echo 'There is nothing in the basket.';
}
```



### Get Total Item

Gets the total of items in the cart.

> **int** \$cart->getTotaltem( );

```php
echo 'There are '.$cart->getTotalItem().' items in the cart.';
```



### Get Total Quantity

Gets the total of quantity in the cart.

> **int** \$cart->getTotalQuantity( );

```php
echo $cart->getTotalQuantity();
```



### Get Attribute Total

Gets the sum of a specific attribute.

> **int** \$cart->getAttributeTotal( **string** $attribute );

```php
echo '<h3>Total Price: $'.number_format($cart->getAttributeTotal('price'), 2, '.', ',').'</h3>';
```



### Clear Cart

Clears all items in the cart.

> \$cart->clear( );

```php
$cart->clear();
```



### Destroy Cart

Destroys the entire cart session.

> \$cart->destroy( );

```php
$cart->destroy();
```



### Item Exists

Checks if an item exists in cart.

> **bool** \$cart->isItemExists( **string** \$id\[, **array** \$attributes\] );

```php
if ($cart->isItemExists('1001')) {
  echo 'This item already added to cart.';
}
```

## Credits
Cart stammt von Sei Kan https://github.com/seikan

Cart auf GitHub: https://github.com/seikan/Cart
