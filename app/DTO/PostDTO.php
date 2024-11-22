<?php
namespace App\DTO;

class PostDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly string $title,
        public readonly string $description,
        public readonly ?int $tomId,
        public readonly array $photos = []
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['user_id'],
            $data['title'],
            $data['description'],
            $data['tom_id'] ?? null,
            array_map(fn($photo) => PhotoDTO::fromArray($photo), $data['photos'] ?? [])
        );
    }
}
