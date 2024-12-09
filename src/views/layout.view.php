<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../output.css">
    <title>TODO App</title>
</head>
<body class="bg-gray-100 min-h-full flex flex-col">
    <?php view('header'); ?>
    
    <div class="container mx-auto px-4 py-8 flex-grow pt-16">
        <?php echo $_page_content; ?>
    </div>

    <?php view('footer'); ?>
</body>
</html>
