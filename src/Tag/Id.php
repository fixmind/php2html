<?php

/**
 * Html 1.0.1
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace FixMind\PhpToHtml\Tag;

class Id extends ClassTag
{
	protected $id = false;
	
	public function addId($idName)
	{
		if ($this->validId($idName))
		{
			if ($this->hasId() == true)
			{
				$this->removeId();
			}
			
			if ($this->idExistsPrimary($idName) == false)
			{
				$this->id = $idName;
			}
			else
			{
				throw new \Exception('ID already exists in this HTML object: "' . $idName . '".');
			}
		}

		return $this;
	}
	
	public function getId($dontThrowExceptionIfDoesntExists = false)
	{
		if ($this->hasId() || $dontThrowExceptionIfDoesntExists == true)
		{
			return $this->id;
		}
		else
		{
			throw new \Exception('This tag hasn\'t ID attribute.');
		}
	}
	
	public function hasId()
	{
		return $this->id == false ? false : true;
	}
	
	public function removeId()
	{
		$this->id = false;
		return $this;
	}
	
	public function idRender()
	{
		if ($this->hasId())
		{
			return $this->getId();
		}
		else
		{
			return '';
		}
	}
	
	public function idExistsPrimary($idName)
	{
		if ($this->validId($idName))
		{
			return $this->getPrimary()->idExists($idName);
		}
	}
	
	public function idExists($idName)
	{
		if ($this->validId($idName))
		{
			if ($this->hasId() && $this->getId() == $idName) return true;
			
			foreach($this->getContentTagList() as $tag)
			{
				if ($tag->idExists($idName)) return true;
			}
		}
	}
	
	private function validId($idName)
	{
		if (preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9]{0,32}$/', $idName) > 0)
		{
			return true;
		}
		else
		{
			throw new \Exception('Invalid tag ID: "' . $idName . '".');
		}
	}
}