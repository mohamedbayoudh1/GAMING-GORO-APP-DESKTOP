/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.esprit.workshop.services;

import java.sql.SQLException;
import java.util.List;

/**
 *
 * @author FGH
 */
public interface IService<T> {
    
    void insertOne(T t) throws SQLException;
    
    void updateOne(T t) throws SQLException;
    
    void deleteOne(T t) throws SQLException;
    void deleteOne(int id) throws SQLException;
    
    List<T> selectAll() throws SQLException;
    
}
