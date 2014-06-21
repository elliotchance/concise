<?php

namespace Concise\Services;

class DataTypeChecker
{
	protected $excludeMode = false;

	protected $context = array();

	public function setContext(array $context)
	{
		$this->context = $context;
	}

	public function check(array $acceptedTypes, $value)
	{
		if($this->excludeMode === true) {
			return $this->throwInvalidArgumentException($acceptedTypes, $value, false, "must not be");
		}

		if(count($acceptedTypes) === 0) {
			return true;
		}
		return $this->throwInvalidArgumentException($acceptedTypes, $value, true, "not found in");
	}

	protected function matchesInAcceptedTypes(array $acceptedTypes, $value)
	{
		foreach($acceptedTypes as $acceptedType) {
			if($this->matches($acceptedType, $value)) {
				return true;
			}
		}
		return false;
	}

	protected function throwInvalidArgumentException(array $acceptedTypes, $value, $expecting, $message)
	{
		$match = $this->matchesInAcceptedTypes($acceptedTypes, $value);
		if($expecting === $match) {
			return true;
		}
		$accepts = implode(' or ', $acceptedTypes);
		throw new \InvalidArgumentException($this->getType($value) . " $message " . $accepts);
	}

	protected function getAttribute($name)
	{
		if(!array_key_exists($name, $this->context)) {
			throw new \Exception("Attribute '$name' does not exist.");
		}
		return $this->context[$name];
	}

	protected function getType($value)
	{
		if(is_object($value)) {
			if(get_class($value) === 'Concise\Syntax\Token\Regexp') {
				return 'regex';
			}
			if(get_class($value) === 'Concise\Syntax\Token\Attribute') {
				return $this->getType($this->getAttribute($value->getValue()));
			}
		}
		if(is_callable($value)) {
			return 'callable';
		}
		return gettype($value);
	}

	protected function matches($type, $value)
	{
		return $this->simpleType($type) === $this->simpleType($this->getType($value));
	}

	protected function simpleType($type)
	{
		if($type === 'integer') {
			$type = 'int';
		}
		else if($type === 'double') {
			$type = 'float';
		}
		else if($type === 'class') {
			$type = 'string';
		}
		return $type;
	}

	public function setExcludeMode()
	{
		$this->excludeMode = true;
	}
}
