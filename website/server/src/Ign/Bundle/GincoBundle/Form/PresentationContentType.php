<?php
namespace Ign\Bundle\GincoBundle\Form;

use Ign\Bundle\GincoBundle\Form\Components\ImageType;
use Ign\Bundle\GincoBundle\Form\Components\LinkFileType;
use Ign\Bundle\GincoBundle\Form\Components\LinkType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ConfigurationType
 * Configuration parameters form type
 * @package Ign\Bundle\GincoBundle\Form
 */
class PresentationContentType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			// The presentation title
			->add('presentationTitle', TextType::class, array(
				'label' => 'Titre page de présentation',
				'constraints' => array(
					new NotBlank(),
				),
			))
			// The presentation intro text field
			->add('presentationIntro', CKEditorType::class, array(
				'required' => false,
				'label' => 'Contenu page de présentation',
				'constraints' => array(
				),
			))
			// The presentation Image
			->add('presentationImage', ImageType::class, array(
				'required' => false,
				'label' => 'Image d\'illustration',
			))
			// The block of public links and documents
			->add('presentationPublicLinksTitle', TextType::class, array(
				'label' => 'Titre du bloc de liens',
			))
			->add('presentationLinks', CollectionType::class, array(
				'entry_type' => LinkType::class,
				'entry_options' => array('label' => 'Lien public', 'required' => false),
			))
			->add('presentationDocs', CollectionType::class, array(
				'entry_type' => LinkFileType::class,
				'entry_options' => array('label' => 'Document public', 'required' => false),
			))
			->add('submit', SubmitType::class, array(
				'label' => 'Configuration.edit.submit.button'
			))
		;
	}

	public function setDefaultOptions(OptionsResolverInterface $resolver)
	{
	}

	public function getName()
	{
		return 'presentation_content_form';
	}
}