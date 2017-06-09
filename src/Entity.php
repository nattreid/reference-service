<?php

declare(strict_types=1);

namespace NAttreid\ReferenceService;

use NAttreid\Utils\Strings;
use Nette\Application\UI\Control;
use Nette\Localization\ITranslator;
use Nette\Reflection\ClassType;
use Nette\Utils\Html;

/**
 * Entity
 *
 * @property-read int $id
 * @property-read string $title
 * @property-read string $entityName
 * @property-read bool $render
 * @property-read Html $prototype
 *
 * @author Attreid <attreid@gmail.com>
 */
abstract class Entity extends Control
{
	/** @var int */
	private $id;

	/** @var string */
	private $shortName;

	/** @var string */
	private $serviceName;

	/** @var ITranslator */
	private $translator;

	public function setup(int $id, string $name): void
	{
		$this->id = $id;
		$this->serviceName = $name;
	}

	public function setTranslator(?ITranslator $translator): void
	{
		$this->translator = $translator;
	}

	protected function getId(): int
	{
		return $this->id;
	}

	protected function getEntityName(): string
	{
		if ($this->shortName === null) {
			$reflection = new ClassType($this);
			$this->shortName = Strings::firstLower($reflection->shortName);
		}
		return $this->shortName;
	}

	protected function getTitle(): string
	{
		$name = $this->serviceName . '.' . $this->entityName;

		if ($this->translator !== null) {
			return $this->translator->translate($name);
		} else {
			return $name;
		}
	}

	protected function isRender(): bool
	{
		return method_exists($this, 'render');
	}

	protected function getPrototype(): Html
	{
		$html = Html::el();
		$html->setText($this->title);
		return $html;
	}
}