INSERT INTO `product_shop`
(`product_id`, `shop_id`, `created_at`, `updated_at`)
VALUES
(
    (SELECT id FROM `products` LIMIT 0, 1),
    (SELECT id FROM `shops` LIMIT 0, 1),
    current_timestamp(), current_timestamp()
),
(
    (SELECT id FROM `products` LIMIT 0, 1),
    (SELECT id FROM `shops` LIMIT 1, 1),
    current_timestamp(), current_timestamp()
),
(
    (SELECT id FROM `products` LIMIT 1, 1),
    (SELECT id FROM `shops` LIMIT 0, 1),
    current_timestamp(), current_timestamp()
),
(
    (SELECT id FROM `products` LIMIT 1, 1),
    (SELECT id FROM `shops` LIMIT 1, 1),
    current_timestamp(), current_timestamp()
),
(
    (SELECT id FROM `products` LIMIT 2, 1),
    (SELECT id FROM `shops` LIMIT 0, 1),
    current_timestamp(), current_timestamp()
),
(
    (SELECT id FROM `products` LIMIT 3, 1),
    (SELECT id FROM `shops` LIMIT 1, 1),
    current_timestamp(), current_timestamp()
);