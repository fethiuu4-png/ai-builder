-- ============================================
-- عقل برو - قاعدة البيانات
-- AqlPro AI Builder Database Schema
-- ============================================

CREATE DATABASE IF NOT EXISTS aqlpro
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE aqlpro;

-- ============================================
-- جدول النماذج
-- ============================================
CREATE TABLE IF NOT EXISTS ai_models (
    id              VARCHAR(30) PRIMARY KEY,
    name            VARCHAR(255) NOT NULL,
    description     TEXT,
    architecture    VARCHAR(50) NOT NULL DEFAULT 'mlp',
    layers          LONGTEXT,
    input_shape     VARCHAR(100) NOT NULL DEFAULT '784',
    output_classes  INT NOT NULL DEFAULT 10,
    status          VARCHAR(20) NOT NULL DEFAULT 'draft',
    dataset         VARCHAR(255),
    epochs          INT NOT NULL DEFAULT 10,
    learning_rate   DECIMAL(10,6) NOT NULL DEFAULT 0.001000,
    batch_size      INT NOT NULL DEFAULT 32,
    optimizer       VARCHAR(50) NOT NULL DEFAULT 'adam',
    loss_function   VARCHAR(50) NOT NULL DEFAULT 'crossentropy',
    accuracy        DECIMAL(10,4),
    loss            DECIMAL(10,4),
    training_history LONGTEXT,
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_updated (updated_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- جدول البيانات المخصّصة
-- ============================================
CREATE TABLE IF NOT EXISTS datasets (
    id              VARCHAR(30) PRIMARY KEY,
    name            VARCHAR(255) NOT NULL,
    description     TEXT,
    type            VARCHAR(20) NOT NULL DEFAULT 'tabular',
    columns         LONGTEXT NOT NULL,
    rows            LONGTEXT NOT NULL,
    row_count       INT NOT NULL DEFAULT 0,
    input_column    VARCHAR(255),
    label_column    VARCHAR(255),
    created_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_type (type),
    INDEX idx_updated (updated_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- بيانات تجريبية (اختيارية)
-- ============================================
INSERT INTO ai_models (id, name, description, architecture, layers, input_shape, output_classes, status, dataset, epochs, learning_rate, batch_size, optimizer, loss_function, accuracy, loss, training_history) VALUES
('demo001', 'مصنف الأرقام التجريبي', 'نموذج MLP لتصنيف الأرقام المكتوبة بخط اليد', 'mlp', '[{"id":"l1","type":"dense","neurons":128,"activation":"relu"},{"id":"l2","type":"dropout","rate":0.2},{"id":"l3","type":"dense","neurons":64,"activation":"relu"},{"id":"l4","type":"dense","neurons":10,"activation":"softmax"}]', '784', 10, 'trained', 'mnist', 15, 0.001000, 32, 'adam', 'crossentropy', 0.8865, 0.3521, '[{"epoch":1,"accuracy":0.4521,"loss":1.5231,"valAccuracy":0.4312,"valLoss":1.5987},{"epoch":5,"accuracy":0.7214,"loss":0.8124,"valAccuracy":0.7023,"valLoss":0.8567},{"epoch":10,"accuracy":0.8341,"loss":0.4823,"valAccuracy":0.8156,"valLoss":0.5234},{"epoch":15,"accuracy":0.8865,"loss":0.3521,"valAccuracy":0.8712,"valLoss":0.3987}]');
