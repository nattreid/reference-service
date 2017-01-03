<?php

namespace NAttreid\ReferenceService;

use NAttreid\Utils\Strings;
use Nette\Application\UI\Control;
use Nette\Reflection\ClassType;

/**
 * Entity
 *
 * @property-read int $id
 * @property-read string $title
 * @property-read boolean $render
 *
 * @author Attreid <attreid@gmail.com>
 */
abstract class Entity extends Control
{
	/** @var int */
	private $id;

	/** @var string */
	private $title;

	/**
	 * Entity constructor.
	 * @param int $id
	 */
	public function __construct($id)
	{
		parent::__construct();
		$this->id = $id;
	}

	/** @return int */
	protected function getId()
	{
		return $this->id;
	}

	/** @return string */
	protected function getTitle()
	{
		if ($this->title === null) {
			$reflection = new ClassType($this);
			$this->title = Strings::firstLower($reflection->shortName);
		}
		return $this->title;
	}

	protected function isRender()
	{
		return method_exists($this, 'render');
	}
}