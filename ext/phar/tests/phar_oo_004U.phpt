--TEST--
Phar and DirectoryIterator
--SKIPIF--
<?php
if (!extension_loaded("phar")) die("skip");
if (!extension_loaded("spl")) die("skip SPL not available");
if (version_compare(PHP_VERSION, "6.0", "!=")) die("skip requires Unicode support");
?>
--INI--
phar.require_hash=0
--FILE--
<?php

require_once 'files/phar_oo_test.inc';

$it = new DirectoryIterator('phar://'.$fname);

foreach($it as $name => $ent)
{
	var_dump($name);
	var_dump($ent->getFilename());
	var_dump($ent->isDir());
	var_dump($ent->isDot());
}

?>
===MANUAL===
<?php

class MyDirectoryIterator extends DirectoryIterator
{
	function __construct($dir)
	{
		echo __METHOD__ . "\n";
		parent::__construct($dir);
	}

	function rewind()
	{
		echo __METHOD__ . "\n";
		parent::rewind();
	}

	function valid()
	{
		echo __METHOD__ . "\n";
		return parent::valid();
	}

	function key()
	{
		echo __METHOD__ . "\n";
		return parent::key();
	}

	function current()
	{
		echo __METHOD__ . "\n";
		return parent::current();
	}

	function next()
	{
		echo __METHOD__ . "\n";
		parent::next();
	}
}

$it = new MyDirectoryIterator('phar://'.$fname);

foreach($it as $name => $ent)
{
	var_dump($name);
	var_dump($ent->getFilename());
}

?>
===DONE===
--CLEAN--
<?php 
unlink(dirname(__FILE__) . '/files/phar_oo_004U.phar.php');
__halt_compiler();
?>
--EXPECT--
int(0)
unicode(5) "a.php"
bool(false)
bool(false)
int(1)
unicode(1) "b"
bool(true)
bool(false)
int(2)
unicode(5) "b.php"
bool(false)
bool(false)
int(3)
unicode(5) "e.php"
bool(false)
bool(false)
===MANUAL===
MyDirectoryIterator::__construct
MyDirectoryIterator::rewind
MyDirectoryIterator::valid
MyDirectoryIterator::current
MyDirectoryIterator::key
int(0)
unicode(5) "a.php"
MyDirectoryIterator::next
MyDirectoryIterator::valid
MyDirectoryIterator::current
MyDirectoryIterator::key
int(1)
unicode(1) "b"
MyDirectoryIterator::next
MyDirectoryIterator::valid
MyDirectoryIterator::current
MyDirectoryIterator::key
int(2)
unicode(5) "b.php"
MyDirectoryIterator::next
MyDirectoryIterator::valid
MyDirectoryIterator::current
MyDirectoryIterator::key
int(3)
unicode(5) "e.php"
MyDirectoryIterator::next
MyDirectoryIterator::valid
===DONE===
