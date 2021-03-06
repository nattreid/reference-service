<?php

declare(strict_types=1);

namespace NAttreid\ReferenceService\DI;

use Nette\DI\CompilerExtension;
use Nette\Reflection\ClassType;

/**
 * Class ReferenceServiceExtension
 *
 * @author Attreid <attreid@gmail.com>
 */
class ReferenceServiceExtension extends CompilerExtension
{
	private $defaults = [
		'classes' => []
	];

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults, $this->getConfig());

		foreach ($config['classes'] as $reference) {
			$reflection = new ClassType($reference);

			$service = $builder->addDefinition($this->prefix($reflection->shortName))
				->setType($reference);

			$classes = call_user_func([$reflection->name, 'getEntities']);
			foreach ($classes as $key => $class) {
				$name = $this->prefix($reflection->shortName . '.' . $key);
				$builder->addDefinition($name)
					->setType($class)
					->addSetup('setTranslator');

				$service->addSetup('add', [$key, '@' . $name]);
			}
		}
	}
}