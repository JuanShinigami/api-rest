<?php
namespace Supplier\Service;

use Supplier\Model\ContactModel;

class ContactService
{
	private $contactModel;
	
	// Instanciamos el modelo de contacto
	public function getContactModel()
	{
		return $this->contactModel = new ContactModel();
	}
	
	// Obtemos los contactos
	public function fetchAll()
	{
		$contacts = $this->getContactModel()->fetchAll();
		return $contacts;
	}
	
	// Agregar contacto
	public function addContact($data)
	{
		$addContact = $this->getContactModel()->addContact($data);
		return $addContact;
	}

	// Editar contacto
	public function editContact($data)
	{
		$editContact = $this->getContactModel()->editContact($data);
		return $editContact;
	}
	
}