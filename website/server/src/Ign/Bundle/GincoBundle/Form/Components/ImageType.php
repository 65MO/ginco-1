<?php
namespace Ign\Bundle\GincoBundle\Form\Components;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class ImageType
 * A custom form type for images (uploaded as files)
 * @package Ign\Bundle\GincoBundle\Form
 */
class ImageType extends AbstractType
{
	private $uploadDirectory;

	public function __construct($uploadDir)
	{
		$this->uploadDirectory = $uploadDir;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('file', HiddenType::class, array())
			->add('uploadedFile', FileType::class, array(
				'label' => 'Nouvelle Image',
			))
			->add('suppressFile', CheckboxType::class, array(
				'label' => 'Supprimer'
			))
			->addModelTransformer(new ImageTransformer($this->uploadDirectory))
		;
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	}
}