<?php
declare(strict_types=1);
namespace Phan\Language\Element;

use \Phan\Language\Context;
use \Phan\Language\Type;
use \Phan\Language\element\Comment;

class Property extends TypedStructuralElement {

    /**
     * @var $def
     * No idea
     */
    private $def;

    /**
     * @var Type
     * ...
     */
    private $type;

    /**
     * @var Type
     * ...
     */
    private $dtype;

    /**
     * @param \phan\Context $context
     * The context in which the structural element lives
     *
     * @param CommentElement $comment,
     * Any comment block associated with the class
     *
     * @param string $name,
     * The name of the typed structural element
     *
     * @param Type $type,
     * A '|' delimited set of types satisfyped by this
     * typed structural element.
     *
     * @param int $flags,
     * The flags property contains node specific flags. It is
     * always defined, but for most nodes it is always zero.
     * ast\kind_uses_flags() can be used to determine whether
     * a certain kind has a meaningful flags value.
     */
    public function __construct(
        Context $context,
        Comment $comment,
        string $name,
        Type $type,
        int $flags
    ) {
        parent::__construct(
            $context,
            $comment,
            $name,
            $type,
            $flags
        );
    }

    /**
     * @param Context $context
     * The context in which the property appears
     *
     * @param \ReflectionProperty $reflection_property
     * The property to create a property structural element
     * from
     *
     * @return Property
     * Get a Property structural element from a ReflectionProperty
     * in a given context
     */
    public static function fromReflectionProperty(
        Context $context,
        \ReflectionProperty $reflection_property
    ) : Property {

        $type =
            $INTERNAL_CLASS_VARS[strtolower($class->getName())]['properties'][$name]
            ?? self::typeMap(gettype($value));

        $property = new Property(
            $context,
            Comment::none(),
            $name,
            new Type($type),
            $property->getModifiers()
        );

        return $property;
    }

    public function getType() : Type {
        return $this->type;
    }

    public function setType(Type $type) {
        $this->type = $type;
    }

    public function getDType() : Type {
        return $this->dtype;
    }

    public function setDtype(Type $type) {
        $this->dtype = $type;
    }

}
