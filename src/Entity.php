<?php

declare(strict_types = 1);

namespace NAttreid\ReferenceService;

use NAttreid\Utils\Strings;
use Nette\Application\UI\Control;
use Nette\Reflection\ClassType;

/**
 * Entity
 *
 * @property-read int $id
 * @property-read string $title
 * @property-read bool $render
 *
 * @author Attreid <attreid@gmail.com>
 */
abstract class Entity extends Control
{
	/** @var int */
	private $id;

	/** @var string */
	private $title;

	public function __construct(int $id)
	{
		parent::__construct();
		$this->id = $id;
	}

	/** @return int */
	protected function getId(): int
	{
		return $this->id;
	}

	/** @return string */
	protected function getTitle(): string
	{
		if ($this->title === null) {
			$reflection = new ClassType($this);
			$this->title = Strings::firstLower($reflection->shortName);
		}
		return $this->title;
	}

	/**
	 * @return bool
	 */
	protected function isRender(): bool
	{
		return method_exists($this, 'render');
	}
}