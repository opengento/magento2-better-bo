import { data } from './seeder';

/**
 * Get attributes
 * 
 * @param code 
 * @param entityId 
 * 
 * @returns 
 */
export const getAttributes = (code: string, entityId: number) => {
    return data(code, entityId);
}
