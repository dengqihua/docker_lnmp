<?php
    // 建立连接
    $conn = mysqli_connect("mysql", "root", '123456');

    // 错误检查
    if (mysqli_connect_errno()) {
        die("连接错误: (" . mysqli_connect_errno() . ") " . mysqli_connect_error());
    }
    // 输出成功连接
    echo "<h1>成功连接 MySQL 服务器</h1>" . PHP_EOL;
    mysqli_close($conn);