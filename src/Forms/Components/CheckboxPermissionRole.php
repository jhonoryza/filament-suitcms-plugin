<?php

namespace Fajar\Filament\Suitcms\Forms\Components;

use Filament\Forms\Components\CheckboxList;
use Filament\Support\Services\RelationshipJoiner;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Closure;

class CheckboxPermissionRole extends CheckboxList
{
    protected string $view = 'filament-suitcms::components.checkbox-permission-role';

    public function relationshipWithGroup(
        string $groupAttribute,
        string | Closure | null $name,
        string | Closure | null $titleAttribute = null,
        ?Closure $modifyQueryUsing = null
    ): static
    {
        $this->relationship = $name ?? $this->getName();
        $this->relationshipTitleAttribute = $titleAttribute;

        $this->options(static function (CheckboxList $component) use ($modifyQueryUsing, $groupAttribute): array {
            $relationship = Relation::noConstraints(fn () => $component->getRelationship());

            $relationshipQuery = app(RelationshipJoiner::class)->prepareQueryForNoConstraints($relationship);

            if ($modifyQueryUsing) {
                $relationshipQuery = $component->evaluate($modifyQueryUsing, [
                    'query' => $relationshipQuery,
                ]) ?? $relationshipQuery;
            }

            if ($component->hasOptionLabelFromRecordUsingCallback()) {
                return $relationshipQuery
                    ->get()
                    ->groupBy($groupAttribute)
                    ->map(function (Collection $permissions) use ($component): array {
                        $data = [];
                        foreach ($permissions as $permission) {
                            $data[$permission->id] = $component->getOptionLabelFromRecord($permission);
                        }
                        return $data;
                    })
                    ->toArray();
            }

            $relationshipTitleAttribute = $component->getRelationshipTitleAttribute();

            if (empty($relationshipQuery->getQuery()->orders)) {
                $relationshipQuery->orderBy('id');
            }

            if (str_contains($relationshipTitleAttribute, '->')) {
                if (! str_contains($relationshipTitleAttribute, ' as ')) {
                    $relationshipTitleAttribute .= " as $relationshipTitleAttribute";
                }
            }

            return $relationshipQuery
                ->get()
                ->groupBy($groupAttribute)
                ->map(function (Collection $permissions) use ($relationshipTitleAttribute, $relationship): array {
                    $data = [];
                    foreach ($permissions as $permission) {
                        $data[$permission->id] = $permission->{$relationshipTitleAttribute};
                    }
                    return $data;
                })
                ->toArray();
        });

        $this->loadStateFromRelationshipsUsing(static function (CheckboxList $component, ?array $state): void {
            unset($state);
            $relationship = $component->getRelationship();

            /** @var \Illuminate\Database\Eloquent\Collection $relatedModels */
            $relatedModels = $relationship->getResults();

            $component->state(
            // Cast the related keys to a string, otherwise Livewire does not
            // know how to handle deselection.
            //
            // https://github.com/filamentphp/filament/issues/1111
                $relatedModels
                    ->pluck($relationship->getRelatedKeyName())
                    ->map(static fn ($key): string => strval($key))
                    ->toArray(),
            );
        });

        $this->saveRelationshipsUsing(static function (CheckboxList $component, ?array $state) {
            $component->getRelationship()->sync($state ?? []);
        });

        $this->dehydrated(false);

        return $this;
    }
}
