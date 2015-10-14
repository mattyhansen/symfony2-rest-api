<?php
$i = new AcceptanceTester($scenario);
$i->wantTo('open home page and see text Welcome');
$i->amOnPage('/');
$i->see('Welcome');
