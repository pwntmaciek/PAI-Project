<?php

namespace BookBundle\Form;

use AuthorBundle\Entity\Author;
use BookBundle\Entity\Book;
use BookBundle\Entity\Enum\StatusEnum;
use BookBundle\Entity\PrintType;
use CategoryBundle\Entity\Category;

use Doctrine\ORM\EntityManager;
use ImageBundle\Entity\Image;
use PublisherBundle\Entity\Publisher;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class BookType
 * @package BookBundle\Form
 */
class BookType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * BookType constructor.
     * @param $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('subtitle', TextType::class)
            ->add('publishedDate', TextType::class)
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'editor-wysihtml5'
                ]
            ])
            ->add('pageCount', IntegerType::class)
            ->add('language', TextType::class)
            ->add('webReaderLink', UrlType::class)
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'choice_label' => function (Author $author) {
                    return $author->getFullName();
                },
                'multiple' => true
            ])
            ->add('printType', EntityType::class, [
                'class' => PrintType::class,
                'choice_label' => function (PrintType $printType){
                    return $printType->getName();
                },
            ])
            ->add('categories', EntityType::class, [
                'class'  => Category::class,
                'choice_label' => function (Category $category){
                    return $category->getName();
                },
                'multiple' => true
            ])
            ->add('publisher', EntityType::class, [
                'class' => Publisher::class
            ])
            ->add('image', EntityType::class, [
                'class' => Image::class,
                'choice_label' => function (Image $image){

                    return $image->getName();
                },
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    StatusEnum::DRAFT()->getValue() => StatusEnum::DRAFT(),
                    StatusEnum::PUBLISHED()->getValue() => StatusEnum::PUBLISHED()
                ]
            ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BookBundle\Entity\Book',
            'required' => false,
            'validation_groups' => function (FormInterface $form) {

                /** @var Book $data */
                $data = $form->getData();

                if($data->getStatus() === StatusEnum::PUBLISHED()->getValue())
                    return ['published'];
            }
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'bookbundle_book';
    }


}
