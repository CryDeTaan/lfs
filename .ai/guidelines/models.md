## Model structure

Models should follow this ordering:

1. Traits (e.g. `HasFactory`, `Notifiable`)
2. Constants
3. Properties & attributes (`$fillable`, `$hidden`, `$guarded`, etc.)
4. Configuration methods (`casts()`, etc.)
5. Relationships — must always have a PHPDoc `@return` block
6. Helper methods & logic
