<?php
namespace App\DTO;

class PostDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly ?int $tom_id,
        public readonly array $photos = []
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['title'],
            $data['description'],
            $data['tom_id'] ?? null,
            array_map(fn($photo) => PhotoDTO::fromArray($photo), $data['photos'] ?? [])
        );
    }
}
