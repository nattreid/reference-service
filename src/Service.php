<?php

namespace NAttreid\ReferenceService;

use InvalidArgumentException;
use NAttreid\Utils\Strings;
use Nette\Localization\ITranslator;
use Nette\Reflection\ClassType;

/**
 * Class Service
 *
 * @author Attreid <attreid@gmail.com>
 */
abstract class Service
{
	/** @var Entity[] */
	private $entities = [];

	/** @var ITranslator */
	private $translator;

	/** @var string */
	protected $name;

	public function __construct(ITranslator $translator)
	{
		if ($this->name === null) {
			$reflection = new ClassType($this);
			$this->name = Strings::firstLower($reflection->shortName);
		}

		$this->translator = $translator;
	}

	/**
	 * @return array[key => class]
	 */
	public static function getEntities()
	{
		return [];
	}

	/**
	 * @param int $key
	 * @param $entity
	 */
	public function add($key, Entity $entity)
	{
		if (isset($this->entities[$key])) {
			throw new InvalidArgumentException('Duplicite key!');
		}
		$this->entities[$key] = $entity;
	}

	/**
	 * @return array
	 */
	public function fetchPairsByName()
	{
		$arr = [];
		foreach ($this->entities as $key => $payment) {
			$arr[$key] = $this->translator->translate($this->name . '.' . $payment->name);
		}
		asort($arr);
		return $arr;
	}

	/**
	 * @return array
	 */
	public function fetchPairsById()
	{
		$arr = [];
		foreach ($this->entities as $key => $payment) {
			$arr[$key] = $this->translator->translate($this->name . '.' . $payment->name);
		}
		return $arr;
	}

	/**
	 * @return array
	 */
	public function fetchUntranslatedPairsById()
	{
		return $this->entities;
	}

	/**
	 *
	 * @param int $id
	 * @return Entity
	 */
	public function getById($id)
	{
		if (isset($this->entities[$id])) {
			return $this->entities[$id];
		} else {
			return null;
		}
	}
}