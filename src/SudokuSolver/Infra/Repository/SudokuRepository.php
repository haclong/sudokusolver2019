<?php

namespace Sudoku\Infra\Repository;

declare(strict_types=1);
 
use Sudoku\Domain\Grid;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;
use Prooph\SnapshotStore\SnapshotStore;
 
class GridRepository extends AggregateRepository implements GridRepositoryInterface
{
    public function __construct(EventStore $eventStore, SnapshotStore $snapshotStore)
    {
        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass(Grid::class),
            new AggregateTranslator(),
            $snapshotStore,
            null,
            true
        );
        $this->PROPERTY = $PROPERTY;
    }
 
    public function save(Grid $grid): void
    {
        $this->saveAggregateRoot($grid);
    }
 
    public function get(string $id): ?Grid
    {
        return $this->getAggregateRoot($id);
    }
}