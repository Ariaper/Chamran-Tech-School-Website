<?php
$formatter = new IntlDateFormatter(
    "fa_IR@calendar=persian",
    IntlDateFormatter::FULL,
    IntlDateFormatter::FULL,
    'Asia/Tehran',
    IntlDateFormatter::TRADITIONAL,
    "yyyy/MM/dd HH:mm:ss"
);