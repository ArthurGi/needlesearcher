<?php

namespace src\Interfaces;

interface SearchInterface
{
    public function findOccurrence(string $needle, string $text): array;
}