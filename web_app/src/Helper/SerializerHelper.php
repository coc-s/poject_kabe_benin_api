<?php

namespace App\Helper;

use App\Entity\PaginatorResponse;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class SerializerHelper
{

  public SerializerInterface $serializer;
  public DenormalizerInterface $denormalizer;
  public HttpClientInterface $client;
  public NormalizerInterface $normalizer;
  public EncoderInterface $encoder;
  public DecoderInterface $decoder;

  public function __construct(

    SerializerInterface $serializer,
    DenormalizerInterface $denormalizer,
    NormalizerInterface $normalizer,
    EncoderInterface $encoder,
    DecoderInterface $decoder
  ) {

    $this->serializer = $serializer;
    $this->denormalizer = $denormalizer;
    $this->normalizer = $normalizer;
    $this->encoder = $encoder;
    $this->decoder = $decoder;
  }
  public function deserializePaginator(string $content, string $type): PaginatorResponse
  {
    $paginatorAdherent = $this->serializer->deserialize($content, "App\Entity\PaginatorResponse", 'json');
    $data = $this->denormalizer->denormalize($paginatorAdherent->getData(), $type . "[]", 'json');
    $paginatorAdherent->setData($data);
    return $paginatorAdherent;
  }
}
