<?php

declare(strict_types=1);

namespace NAttreid\ReferenceService;

use NAttreid\Utils\Strings;
use Nette\Application\UI\Control;
use Nette\Reflection\ClassType;

/**
 * Entity
 *
 * @property-read int $id
 * @property-read string $title
 * @property-read string $entityName
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

	/** @var Service */
	private $service;

	public function __construct(int $id)
	{
		parent::__construct();
		$this->id = $id;
	}

	/**
	 * @param Service $service
	 */
	public function setService(Service $service): void
	{
		$this->service = $service;
	}

	/** @return int */
	protected function getId(): int
	{
		return $this->id;
	}

	/** @return string */
	protected function getEntityName(): string
	{
		if ($this->title === null) {
			$reflection = new ClassType($this);
			$this->title = Strings::firstLower($reflection->shortName);
		}
		return $this->title;
	}

	/** @return string */
	protected function getTitle(): string
	{
		return $this->service->translate($this);
	}

	/**
	 * @return bool
	 */
	protected function isRender(): bool
	{
		return method_exists($this, 'render');
	}
}