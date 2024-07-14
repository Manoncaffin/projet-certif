<?php 

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FirstLetterExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('first_letter', [$this, 'getFirstLetter']),
        ];
    }

    public function getFirstLetter(string $string): string
    {
        return mb_substr($string, 0, 1); // Récupère la première lettre de la chaîne $string
    }
}
