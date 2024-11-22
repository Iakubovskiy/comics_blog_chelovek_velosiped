<?php
namespace App\DTO;

class PhotoDTO
{
    public function __construct(
        public readonly ?int $id,
        public readonly string $url,
        public readonly int $photoNumber
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'] ?? null,
            $data['url'],
            $data['photo_number']
        );
    }
}
