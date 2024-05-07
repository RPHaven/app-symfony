<?php

declare(strict_types=1);

namespace RpHaven\App\Uid\Uuid\Id;


use Nyholm\Psr7\Uri;
use RpHaven\App\Uid\Traits\BinaryUid;
use RpHaven\App\Uid\Traits\Rfc4122Uid;
use RpHaven\App\Uid\Uuid\Traits\UuidV6Type;
use RpHaven\Uid\Id\SpaceId;
use RpHaven\Uid\Traits\ToString;

final readonly class TableUid implements TableId
{
    use BinaryUid;
    use Rfc4122Uid;
    use UuidV6Type;
    use ToString;

    public const OID = Oid::TABLE;

    public static function create(SpaceId $spaceId, \RpHaven\Games\Table $table): self
    {
        return new self(
            Uuid::v5(self::OID->namespace(), sprintf(
                '%s:%s:%s',
                $spaceId,
                $table->lifetime->start()->format(DATE_ATOM),
                $table->lifetime->end()->format(DATE_ATOM),
            ))
        );
    }

    private static function oid(): Uri
    {
        return new Uri(self::OID);
    }

}
