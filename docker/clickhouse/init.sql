-- Kafka engine table: reads raw messages from the search_events topic
CREATE TABLE IF NOT EXISTS search_events_queue (
    query       String,
    user_id     Nullable(UInt64),
    results     UInt32,
    searched_at DateTime
) ENGINE = Kafka
SETTINGS
    kafka_broker_list = 'kafka:9092',
    kafka_topic_list = 'search_events',
    kafka_group_name = 'clickhouse_search_consumer',
    kafka_format = 'JSONEachRow',
    kafka_num_consumers = 1;

-- Final MergeTree table: stores all search events
CREATE TABLE IF NOT EXISTS search_events (
    query       String,
    user_id     Nullable(UInt64),
    results     UInt32,
    searched_at DateTime
) ENGINE = MergeTree()
ORDER BY searched_at;

-- Materialized view: auto-inserts from Kafka queue into the MergeTree table
CREATE MATERIALIZED VIEW IF NOT EXISTS search_events_mv TO search_events AS
SELECT * FROM search_events_queue;

-- Kafka engine table: reads raw messages from the page_navigation_events topic
CREATE TABLE IF NOT EXISTS page_navigation_events_queue (
    user_id       Nullable(UInt64),
    prev_url      String,
    new_url       String,
    navigated_at  DateTime
) ENGINE = Kafka
SETTINGS
    kafka_broker_list = 'kafka:9092',
    kafka_topic_list = 'page_navigation_events',
    kafka_group_name = 'clickhouse_navigation_consumer',
    kafka_format = 'JSONEachRow',
    kafka_num_consumers = 1;

-- Final MergeTree table: stores all page navigation events
CREATE TABLE IF NOT EXISTS page_navigation_events (
    user_id       Nullable(UInt64),
    prev_url      String,
    new_url       String,
    navigated_at  DateTime
) ENGINE = MergeTree()
ORDER BY navigated_at;

-- Materialized view: auto-inserts from Kafka queue into the MergeTree table
CREATE MATERIALIZED VIEW IF NOT EXISTS page_navigation_events_mv TO page_navigation_events AS
SELECT * FROM page_navigation_events_queue;
