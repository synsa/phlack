<?php

namespace spec\Crummy\Phlack\Message;

use Crummy\Phlack\Message\Collection\FieldCollection;
use Crummy\Phlack\Message\FieldInterface;
use PhpSpec\ObjectBehavior;

class AttachmentSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(['fallback' => get_class()]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Message\Attachment');
    }

    public function it_is_encodable()
    {
        $this->shouldImplement('\Crummy\Phlack\Common\Encodable');
    }

    public function it_provides_a_fluent_interface()
    {
        $this->setFallback('fallback')->shouldReturn($this);
        $this->setText('text')->shouldReturn($this);
        $this->setPretext('pretext')->shouldReturn($this);
        $this->setColor('danger')->shouldReturn($this);
        $this->setAuthorName('author name')->shouldReturn($this);
        $this->setAuthorLink('author link')->shouldReturn($this);
        $this->setAuthorIcon('http://domain.com/icon.png')->shouldReturn($this);
        $this->setTitle('title')->shouldReturn($this);
        $this->setTitleLink('http://www.title-link.com/')->shouldReturn($this);
        $this->setImageUrl('http://domain.com/image.png')->shouldReturn($this);
        $this->setThumbUrl('http://domain.com/thumb.png')->shouldReturn($this);
        $this->setMrkdwnIn(['text', 'pretext'])->shouldReturn($this);
    }

    public function it_contains_a_field_collection()
    {
        $this['fields']->shouldReturnAnInstanceOf('\Crummy\Phlack\Message\Collection\FieldCollection');
    }

    public function it_fluently_adds_field_interfaces(FieldInterface $field)
    {
        $this->addField($field)->shouldReturn($this);
    }

    public function it_adds_fields_to_the_collection(FieldCollection $fields, FieldInterface $field)
    {
        $fields->add($field)->shouldBeCalled();

        $this->setFields($fields);
        $this->addField($field);
    }

    public function it_increments_the_field_count_on_add(FieldInterface $field)
    {
        $this->addField($field);
        $this->getFields()->shouldHaveCount(1);
    }

    public function it_adds_fields_to_serialized_output(FieldInterface $field)
    {
        $this->addField($field);
        $this->jsonSerialize()['fields']->shouldHaveCount(1);
    }
}
