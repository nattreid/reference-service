<?php

namespace NAttreid\ReferenceService;

use NAttreid\Utils\Strings;
use Nette\Reflection\ClassType;
use Nette\SmartObject;

/**
 * Entity
 *
 * @property-read int $id
 * @property-read string $name
 *
 * @author Attreid <attreid@gmail.com>
 */
abstract class Entity
{
	use SmartObject;

	/** @var int */
	private $id;

	/** @var string */
	private $name;

	/**
	 * Entity constructor.
	 * @param int $id
	 */
	public function __construct($id)
	{
		$this->id = $id;
	}

	/** @return int */
	public function getId()
	{
		return $this->id;
	}

	/** @return string */
	public function getName()
	{
		if ($this->name === null) {
			$reflection = new ClassType($this);
			$this->name = Strings::firstLower($reflection->shortName);
		}
		return $this->name;
	}
}