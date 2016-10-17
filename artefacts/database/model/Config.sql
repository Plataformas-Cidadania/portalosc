CREATE EXTENSION pg_trgm;

CREATE TEXT SEARCH CONFIGURATION portuguese_unaccent(COPY = portuguese);
ALTER TEXT SEARCH CONFIGURATION portuguese_unaccent ALTER MAPPING FOR hword, hword_part, word WITH unaccent, portuguese_stem;
